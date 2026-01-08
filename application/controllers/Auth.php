<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    /**
     * Clear old flashdata to prevent duplicate toast notifications
     */
    private function _clear_flashdata()
    {
        // Clear flashdata (both new and old)
        $this->session->unset_userdata('success');
        $this->session->unset_userdata('error');
        $this->session->unset_userdata('__ci_vars');
        
        // Clear tempdata
        $this->session->unset_tempdata('success');
        $this->session->unset_tempdata('error');
        
        // Clear all flashdata-related keys
        $all_userdata = $this->session->userdata();
        foreach ($all_userdata as $key => $value) {
            // Clear session markers
            if (strpos($key, 'flashdata_shown_') === 0) {
                $this->session->unset_userdata($key);
            }
            // Clear consumed markers
            if (strpos($key, 'toast_consumed_') === 0) {
                $this->session->unset_userdata($key);
            }
            // Clear CodeIgniter internal flashdata keys
            if (strpos($key, '__ci_old_') === 0 || strpos($key, '__ci_new_') === 0) {
                $this->session->unset_userdata($key);
            }
        }
    }
    
    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasinya sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        //jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                //cek passwordnya
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    
                    // Clear any old flashdata before setting new one
                    $this->_clear_flashdata();
                    
                    // Set success message for login
                    $this->session->set_flashdata('success', 'Welcome back! You have been logged in successfully.');
                    
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    // Clear old flashdata
                    $this->_clear_flashdata();
                    $this->session->set_flashdata('error', 'Wrong password!');
                    redirect('auth');
                }
            } else {
                // Clear old flashdata
                $this->_clear_flashdata();
                $this->session->set_flashdata('error', 'This email has not been activated!');
                redirect('auth');
            }
        } else {
            // Clear old flashdata
            $this->_clear_flashdata();
            $this->session->set_flashdata('error', 'Email is not registered!');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'password', 'required|trim|min_length[3]|matches[password1]');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);

            // Clear old flashdata
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'Registration successful! Please wait for administrator to activate your account.');
            redirect('auth');
        }
    }


    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'eos.bekasi@gmail.com',
            'smtp_pass' => 'sempakbolong',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"

        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('eos.bekasi@gmail.com', 'Administrator KFA');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }


        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('success', $email . ' has been activated! Please login.');
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('error', 'Account activation failed! Token expired.');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Account activation failed! Wrong token.');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Account activation failed! Wrong email.');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        // Clear any old flashdata before setting new one
        $this->_clear_flashdata();
        
        $this->session->set_flashdata('success', 'You have been logged out successfully!');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                // Set password default menjadi "password123"
                $new_password = password_hash('password123', PASSWORD_DEFAULT);
                
                $this->db->set('password', $new_password);
                $this->db->where('email', $email);
                $this->db->update('user');

                // Clear old flashdata
                $this->_clear_flashdata();
                $this->session->set_flashdata('success', 'Password has been reset successfully! Your new password is: password123. Please login with your new password.');
                redirect('auth');
            } else {
                // Clear old flashdata
                $this->_clear_flashdata();
                $this->session->set_flashdata('error', 'Email is not registered or not activated!');
                redirect('auth/forgotpassword');
            }
        }
    }


    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('error', 'Reset password failed! Wrong token.');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Reset password failed! Wrong email.');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[3]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('success', 'Password has been changed successfully! Please login.');
            redirect('auth');
        }
    }
}

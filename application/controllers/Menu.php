<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model', 'menu');
    }

    /**
     * Clear old flashdata and session markers to prevent duplicate toast
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
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'New menu added successfully!');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'New submenu added successfully!');
            redirect('menu/submenu');
        }
    }

    public function editMenu()
    {
        $id = $this->uri->segment(3);
        if (!$id) show_404();
        
        $this->db->update('user_menu', ['menu' => $this->input->post('menu')], ['id' => $id]);
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Menu has been updated successfully!');
        redirect('menu');
    }

    public function deleteMenu()
    {
        $id = $this->uri->segment(3);
        if (!$id) show_404();
        
        $this->db->delete('user_menu', ['id' => $id]);
        $this->db->delete('user_sub_menu', ['menu_id' => $id]);
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Menu has been deleted successfully!');
        redirect('menu');
    }

    public function editSubMenu()
    {
        $id = $this->uri->segment(3);
        if (!$id) show_404();
        
        $this->menu->saveSubMenu($id);

        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Submenu has been updated successfully!');
        redirect('menu/submenu');
    }

    public function deleteSubMenu()
    {
        $id = $this->uri->segment(3);
        if (!$id) show_404();
        
        $this->menu->deleteSubMenu($id);
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Submenu has been deleted successfully!');
        redirect('menu/submenu');
    }
}

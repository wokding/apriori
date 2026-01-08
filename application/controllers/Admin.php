<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model', 'admin');
        $this->load->helper('bulan_helper', 'bulan');
        $this->load->helper('rupiah_helper', 'rupiah');
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
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['data_transaksi'] = $this->admin->data_transaksi();
        $data['hasil_proses'] = $this->admin->hasil_proses();
        $data['jumlah_user'] = $this->admin->jumlah_user();
        $data['nama_role'] = $this->admin->nama_role();
        $data['stats'] = $this->admin->getCleanupStats();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'New role has been added successfully!');
            redirect('admin/role');
        }
    }

    public function editRole()
    {
        $id = $this->input->post('id');
        $role = $this->input->post('role');

        $this->db->where('id', $id);
        $this->db->update('user_role', ['role' => $role]);
        
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Role has been updated successfully!');
        redirect('admin/role');
    }

    public function deleteRole($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
        
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Role has been deleted successfully!');
        redirect('admin/role');
    }

    public function users()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Get all users with role name
        $this->db->select('user.*, user_role.role');
        $this->db->from('user');
        $this->db->join('user_role', 'user_role.id = user.role_id');
        $this->db->order_by('user.date_created', 'ASC');
        $data['users'] = $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer');
    }

    public function toggleUserStatus($id)
    {
        $user = $this->db->get_where('user', ['id' => $id])->row_array();
        
        if ($user) {
            $new_status = $user['is_active'] == 1 ? 0 : 1;
            $this->db->where('id', $id);
            $this->db->update('user', ['is_active' => $new_status]);
            
            $status_text = $new_status == 1 ? 'activated' : 'deactivated';
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'User has been ' . $status_text . ' successfully!');
        }
        
        redirect('admin/users');
    }

    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
        
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'User has been deleted successfully!');
        redirect('admin/users');
    }

    public function changeUserRole()
    {
        $id = $this->input->post('id');
        $role_id = $this->input->post('role_id');

        $this->db->where('id', $id);
        $this->db->update('user', ['role_id' => $role_id]);

        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'User role has been updated successfully!');
        redirect('admin/users');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=');
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Access changed successfully!');
    }

    public function datatransaksi()
    {
        $data['title'] = 'Data Transaksi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['dataTransaksi'] = $this->db->get('transaksi')->result_array();

        $this->form_validation->set_rules('id_transaksi', 'Kode', 'required');
        $this->form_validation->set_rules('transaction_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('produk', 'Produk', 'required');
        $this->form_validation->set_rules('total', 'Total harga', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/datatransaksi', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'id_transaksi' => $this->input->post('id_transaksi'),
                'transaction_date' => $this->input->post('transaction_date'),
                'produk' => $this->input->post('produk'),
                'total' => $this->input->post('total')
            ];
            $this->db->insert('transaksi', $data);
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'Transaction has been added successfully!');
            redirect('admin/datatransaksi');
        }
    }

    public function editDataTransaksi($id)
    {
        $this->admin->updateDataTransaksi($id);
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Transaction has been updated successfully!');
        redirect('admin/datatransaksi');
    }

    public function deleteDataTransaksi($id)
    {
        $this->admin->deleteDataTransaksi($id);
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'Transaction has been deleted successfully!');
        redirect('admin/datatransaksi');
    }

    public function deleteAllDataTransaksi()
    {
        $this->admin->deleteAllDataTransaksi();
        $this->_clear_flashdata();
        $this->session->set_flashdata('success', 'All transactions have been deleted successfully!');
        redirect('admin/datatransaksi');
    }



    // file upload functionality
    public function importTransaksi()
    {
        $data = array();
        // Load form validation library
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fileURL', 'Upload File', 'callback_checkFileValidation');
        // If file uploaded
        if (!empty($_FILES['fileURL']['name'])) {
            // get file extension
            $extension = pathinfo($_FILES['fileURL']['name'], PATHINFO_EXTENSION);
            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }
            // file path
            $spreadsheet = $reader->load($_FILES['fileURL']['tmp_name']);
            $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            // array Count
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('id_transaksi', 'transaction_date', 'produk', 'total');
            $makeArray = array('id_transaksi' => 'id_transaksi', 'transaction_date' => 'transaction_date', 'produk' => 'produk', 'total' => 'total');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    }
                }
            }
            $dataDiff = array_diff_key($makeArray, $SheetDataKey);
            if (empty($dataDiff)) {
                $flag = 1;
            }
            // match excel sheet column
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {
                    $addresses = array();
                    $no = '';
                    $id_transaksi = $SheetDataKey['id_transaksi'];
                    $transaction_date = $SheetDataKey['transaction_date'];
                    $produk = $SheetDataKey['produk'];
                    $total = $SheetDataKey['total'];

                    $id_transaksi = filter_var(trim($allDataInSheet[$i][$id_transaksi]), FILTER_SANITIZE_STRING);
                    $transaction_date = filter_var(trim($allDataInSheet[$i][$transaction_date]), FILTER_SANITIZE_STRING);
                    $produk = filter_var(trim($allDataInSheet[$i][$produk]), FILTER_SANITIZE_STRING);
                    $total = filter_var(trim($allDataInSheet[$i][$total]), FILTER_SANITIZE_STRING);

                    //membalik/mengubah format tanggal menjadi 0000-00-00 jika format tanggalnya 00/00/0000
                    $text = explode("/", $transaction_date);
                    if (strlen($text[2]) == 4) {
                        $transaction_date = $text[2] . "-" . $text[0] . "-" . $text[1];
                    }

                    $fetchData[] = array('id' => $no, 'id_transaksi' => $id_transaksi, 'transaction_date' => $transaction_date, 'produk' => $produk, 'total' => $total);
                }
                $data['transaksi'] = $fetchData;
                $this->admin->setBatchImport($fetchData);
                $this->admin->importData();
                $this->_clear_flashdata();
                $this->session->set_flashdata('success', 'Transactions have been imported successfully!');
            } else {
                $this->_clear_flashdata();
                $this->session->set_flashdata('error', 'Please import correct file, did not match excel sheet column');
            }
            redirect('admin/datatransaksi');
        }
    }




    public function prosesapriori()
    {
        if (isset($_POST['range_tanggal'])) {
            // Set PHP limits untuk proses mining yang lama (support 1 tahun atau lebih)
            set_time_limit(1800); // 30 menit
            ini_set('memory_limit', '1024M'); // 1GB
            ini_set('max_execution_time', '1800');
            @ini_set('max_input_time', '1800');

            $awal = microtime(true);
            $post = $this->input->post();
            $min_support = $_POST['support'];
            $min_confidence = $_POST['confidence'];

            $tgl = explode(" - ", $_POST['range_tanggal']);
            $start = $tgl[0];
            $end = $tgl[1];


            $mining = $this->admin->miningProcess($min_support, $min_confidence, $start, $end);
            $lastId = $this->admin->getLastIdProcessLog();
            $last = $lastId->last;
            $akhir = microtime(true);

            $hasil = $akhir - $awal;

            if ($mining) {
                // Get process_id instead of id
                $process_data = $this->admin->getRuleID($last);
                $process_id = !empty($process_data->process_id) ? $process_data->process_id : 'DM-' . str_pad($last, 3, '0', STR_PAD_LEFT);
                
                $this->_clear_flashdata();
                $this->session->set_flashdata('success', 'Mining process completed successfully!');
                redirect('admin/viewRule/' . $process_id);
            } else {
                $this->_clear_flashdata();
                $this->session->set_flashdata('error', 'Mining process failed. Please check your parameters and try again.');
                redirect('admin/prosesapriori');
            }
        } else {


            $data['title'] = 'Proses Apriori';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/prosesapriori', $data);
            $this->load->view('templates/footer');
        }
    }


    public function hapusRule($id)
    {
        $process_id = $this->uri->segment(3);
        
        if (!isset($process_id)) show_404();
        
        // Convert process_id to id
        $id = $this->admin->getIdFromProcessId($process_id);
        if (!$id) show_404();
        
        if ($this->admin->deleteRule($id)) {
            $this->_clear_flashdata();
            $this->session->set_flashdata('success', 'Rule Berhasil dihapus');
            redirect(site_url('admin/hasil'));
        }
    }

    public function viewRule($id)
    {
        $process_id = $this->uri->segment(3);
        
        // Convert process_id to id
        $id = $this->admin->getIdFromProcessId($process_id);
        if (!$id) show_404();

        $data["ConfidenceItemset3"] = $this->admin->confidenceItemset3($id);
        $data["ConfidenceItemset2"] = $this->admin->confidenceItemset2($id);
        $data["RuleID"] = $this->admin->getRuleID($id);
        $data["ItemSet1"] = $this->admin->getItemset1($id);
        $data["ItemSet2"] = $this->admin->getItemset2($id);
        $data["ItemSet3"] = $this->admin->getItemset3($id);


        $data['title'] = 'Hasil - View Rule';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view_rule', $data);
        $this->load->view('templates/footer');
    }


    public function viewRulePDF($id)
    {
        // Enable error reporting untuk debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // Clear ALL caches
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        if (function_exists('apc_clear_cache')) {
            apc_clear_cache();
        }
        clearstatcache(true);
        
        $process_id = $this->uri->segment(3);
        
        // Convert process_id to id
        $id = $this->admin->getIdFromProcessId($process_id);
        if (!$id) show_404();

        // Load helper
        $this->load->helper('rupiah');

        $data["ConfidenceItemset3"] = $this->admin->confidenceItemset3($id);
        $data["ConfidenceItemset2"] = $this->admin->confidenceItemset2($id);
        $data["RuleID"] = $this->admin->getRuleID($id);
        $data["ItemSet1"] = $this->admin->getItemset1($id);
        $data["ItemSet2"] = $this->admin->getItemset2($id);
        $data["ItemSet3"] = $this->admin->getItemset3($id);

        $data['title'] = 'Hasil - View Rule';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Generate HTML
        ob_start();
        $this->load->view('admin/view_rule_pdf', $data);
        $html = ob_get_clean();

        // Include Dompdf library
        require_once(APPPATH . '../vendor/autoload.php');

        // Allow image loading from filesystem/base_url and enable HTML5 parser for better rendering
        $dompdfOptions = new Dompdf\Options();
        $dompdfOptions->set('isRemoteEnabled', true);
        $dompdfOptions->set('isHtml5ParserEnabled', true);
        $dompdfOptions->setChroot(FCPATH);

        $dompdf = new Dompdf\Dompdf($dompdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Hasil_Rule_' . $id . '.pdf', array('Attachment' => 0));
        exit;
    }

    public function hasil()
    {
        $data['title'] = 'Hasil';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['hasil'] = $this->admin->getHasil();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/hasil', $data);
        $this->load->view('templates/footer');
    }

    public function cleanup()
    {
        $data['title'] = 'Database Cleanup';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        // Get statistics
        $data['stats'] = $this->admin->getCleanupStats();
        $data['processes'] = $this->admin->getProcessList();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/cleanup', $data);
        $this->load->view('templates/footer');
    }

    public function deleteProcess($id)
    {
        $result = $this->admin->deleteProcessData($id);
        
        $this->_clear_flashdata();
        if ($result) {
            $this->session->set_flashdata('success', 'Process data deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete process data.');
        }
        
        redirect('admin/cleanup');
    }

    public function deleteOldProcesses()
    {
        $keep_latest = $this->input->post('keep_latest');
        
        $this->_clear_flashdata();
        if (!$keep_latest || $keep_latest < 1) {
            $this->session->set_flashdata('error', 'Invalid number specified.');
            redirect('admin/cleanup');
            return;
        }
        
        $result = $this->admin->deleteOldProcesses($keep_latest);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Old processes cleaned up successfully!');
        } else {
            $this->session->set_flashdata('error', 'Cleanup failed or no old data to delete.');
        }
        
        redirect('admin/cleanup');
    }

    public function deleteAllProcesses()
    {
        $result = $this->admin->deleteAllProcessData();
        
        $this->_clear_flashdata();
        if ($result) {
            $this->session->set_flashdata('success', 'All process data deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete all process data.');
        }
        
        redirect('admin/cleanup');
    }
}

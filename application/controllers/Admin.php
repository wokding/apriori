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

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
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
            $this->session->set_flashdata('success', 'Transaction has been added successfully!');
            redirect('admin/datatransaksi');
        }
    }

    public function editDataTransaksi($id)
    {
        $this->admin->updateDataTransaksi($id);
        $this->session->set_flashdata('success', 'Transaction has been updated successfully!');
        redirect('admin/datatransaksi');
    }

    public function deleteDataTransaksi($id)
    {
        $this->admin->deleteDataTransaksi($id);
        $this->session->set_flashdata('success', 'Transaction has been deleted successfully!');
        redirect('admin/datatransaksi');
    }

    public function deleteAllDataTransaksi()
    {
        $this->admin->deleteAllDataTransaksi();
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
            } else {
                echo "Please import correct file, did not match excel sheet column";
            }
            $this->session->set_flashdata('success', 'Transactions have been imported successfully!');
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
                
                $this->session->set_flashdata('success', 'Mining process completed successfully!');
                redirect('admin/viewRule/' . $process_id);
            } else {
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

        // Include mPDF library - force new instance
        require(APPPATH . 'third_party/MPDF57/mpdf.php');

        // Create PDF
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output('Hasil_Rule_' . $id . '.pdf', 'I');
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
        
        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Process data deleted successfully!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to delete process data.</div>');
        }
        
        redirect('admin/cleanup');
    }

    public function deleteOldProcesses()
    {
        $keep_latest = $this->input->post('keep_latest');
        
        if (!$keep_latest || $keep_latest < 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid number specified.</div>');
            redirect('admin/cleanup');
            return;
        }
        
        $result = $this->admin->deleteOldProcesses($keep_latest);
        
        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Old processes cleaned up successfully!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Cleanup failed or no old data to delete.</div>');
        }
        
        redirect('admin/cleanup');
    }

    public function deleteAllProcesses()
    {
        $result = $this->admin->deleteAllProcessData();
        
        if ($result) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">All process data deleted successfully!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to delete all process data.</div>');
        }
        
        redirect('admin/cleanup');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function getAllTransaksi()
    {
        $sql = "SELECT * FROM transaksi";
        return $this->db->query($sql)->result();
    }

    public function getHasil()
    {
        $sql = "SELECT * FROM process_log ORDER BY id ASC";
        return $this->db->query($sql)->result();
    }

    public function generateProcessId()
    {
        // Ambil semua process_id yang sudah ada
        $sql = "SELECT process_id FROM process_log WHERE process_id IS NOT NULL ORDER BY process_id ASC";
        $existing_ids = $this->db->query($sql)->result();
        
        // Extract nomor dari process_id yang ada
        $used_numbers = array();
        foreach ($existing_ids as $row) {
            if (preg_match('/DM-(\d+)/', $row->process_id, $matches)) {
                $used_numbers[] = (int)$matches[1];
            }
        }
        
        // Cari nomor terkecil yang belum digunakan, mulai dari 1
        $next_number = 1;
        while (in_array($next_number, $used_numbers)) {
            $next_number++;
        }
        
        // Format: DM-001, DM-002, dst
        return 'DM-' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
    }

    public function regenerateAllProcessIds()
    {
        // Ambil semua record, urutkan berdasarkan id (chronological order)
        $sql = "SELECT id FROM process_log ORDER BY id ASC";
        $records = $this->db->query($sql)->result();
        
        // Update setiap record dengan process_id berurutan
        $counter = 1;
        foreach ($records as $record) {
            $new_process_id = 'DM-' . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $this->db->where('id', $record->id);
            $this->db->update('process_log', array('process_id' => $new_process_id));
            $counter++;
        }
        
        return true;
    }
    
    public function getIdFromProcessId($process_id)
    {
        // Jika sudah angka (backward compatibility), return as is
        if (is_numeric($process_id)) {
            return $process_id;
        }
        
        // Cari id berdasarkan process_id
        $sql = "SELECT id FROM process_log WHERE process_id = ?";
        $result = $this->db->query($sql, array($process_id))->row();
        
        return $result ? $result->id : null;
    }

    public function getTotalTransaksi()
    {
        $sql = "SELECT * FROM transaksi";
        return $this->db->query($sql)->num_row();
    }

    public function updateDataTransaksi($id)
    {
        $post = $this->input->post();
        $this->db->set("id_transaksi", $post["id_transaksi"]);
        $this->db->set("transaction_date", $post["transaction_date"]);
        $this->db->set("total", $post["total"]);
        $this->db->set("produk", $post["produk"]);
        $this->db->where("id", $id);
        $this->db->update("transaksi");
    }

    public function deleteDataTransaksi($id)
    {
        $this->db->delete('transaksi', ['id' => $id]);
    }

    public function deleteAllDataTransaksi()
    {
        $this->db->truncate('transaksi');
    }

    public function deleteRule($id)
    {
        $this->db->delete("process_log", array("id" => $id));
        $this->db->delete("confidence", array("id_process" => $id));
        $this->db->delete("itemset1", array("id_process" => $id));
        $this->db->delete("itemset2", array("id_process" => $id));
        $this->db->delete("itemset3", array("id_process" => $id));
        
        // Regenerate semua process_id supaya berurutan dari DM-001
        $this->regenerateAllProcessIds();

        return true;
    }

    private $_batchImport;

    public function setBatchImport($batchImport)
    {
        $this->_batchImport = $batchImport;
    }

    // save data
    public function importData()
    {
        $data = $this->_batchImport;
        $this->db->insert_batch('transaksi', $data);
    }

    // Confidence ItemSet 3
    public function confidenceItemset3($id, $limit = 1000)
    {
        $sql = "SELECT conf.*, log.start_date, log.end_date FROM confidence conf 
                INNER JOIN process_log log ON conf.id_process = log.id 
                WHERE conf.id_process = '$id' AND conf.from_itemset = 3 LIMIT " . intval($limit);
        return $this->db->query($sql)->result();
    }

    // Confidence ItemSet 2
    public function confidenceItemset2($id, $limit = 1000)
    {
        $sql = "SELECT conf.*, log.start_date, log.end_date FROM confidence conf 
                INNER JOIN process_log log ON conf.id_process = log.id 
                WHERE conf.id_process = '$id' AND conf.from_itemset = 2 LIMIT " . intval($limit);
        return $this->db->query($sql)->result();
    }

    // Get Rule Info
    public function getRuleID($id)
    {
        $sql = "SELECT * FROM process_log WHERE id = '$id'";
        return $this->db->query($sql)->row();
    }

    // Count total confidence rules
    public function countConfidenceRules($id, $from_itemset = null)
    {
        if ($from_itemset) {
            $sql = "SELECT COUNT(*) as total FROM confidence WHERE id_process = '$id' AND from_itemset = " . intval($from_itemset);
        } else {
            $sql = "SELECT COUNT(*) as total FROM confidence WHERE id_process = '$id'";
        }
        return $this->db->query($sql)->row()->total;
    }

    // Get Itemset 1
    public function getItemset1($id)
    {
        $sql = "SELECT * FROM itemset1 WHERE id_process = '$id' " . " ORDER BY lolos DESC";
        return $this->db->query($sql)->result();
    }

    // Get Itemset 2
    public function getItemset2($id, $limit = 500)
    {
        $sql = "SELECT * FROM itemset2 WHERE id_process = '$id' " . " ORDER BY lolos DESC LIMIT " . intval($limit);
        return $this->db->query($sql)->result();
    }

    // Get Itemset 3
    public function getItemset3($id, $limit = 500)
    {
        $sql = "SELECT * FROM itemset3 WHERE id_process = '$id' " . " ORDER BY lolos DESC LIMIT " . intval($limit);
        return $this->db->query($sql)->result();
    }

    public function getRentangTanggalTransaksi()
    {
        $post = $this->input->post();

        if (isset($_POST['range_tanggal'])) {
            $tgl = explode(" - ", $_POST['range_tanggal']);
            $start = format_date($tgl[0]);
            $end = format_date($tgl[1]);
            $sql = "SELECT * FROM transaksi WHERE transaction_date BETWEEN '$start' AND '$end'";
        }


        return $this->db->query($sql)->result();
    }

    public function getJumlahRentangTanggalTransaksi()
    {
        $post = $this->input->post();
        $tgl = explode(" - ", $_POST['range_tanggal']);
        $start = format_date($tgl[0]);
        $end = format_date($tgl[1]);

        $sql = "SELECT * FROM transaksi WHERE transaction_date BETWEEN '$start' AND '$end'";

        return $this->db->query($sql)->num_rows();
    }

    public function tambahProcessLog($min_support, $min_confidence, $start, $end)
    {
        $process_id = $this->generateProcessId();
        
        $data = array(
            'process_id' => $process_id,
            'start_date' => $start,
            'end_date' => $end,
            'min_support' => $min_support,
            'min_confidence' => $min_confidence
        );
        $this->db->insert('process_log', $data);
    }

    public function getLastIdProcessLog()
    {
        $sql = "SELECT max(Id) as last FROM process_log";
        $last = $this->db->query($sql)->row();
        return $last;
    }

    function get_variasi_itemset3($array_itemset3, $item1, $item2, $item3, $item4)
    {
        $return = array();

        $return1 = array();

        if (!in_array(strtoupper($item1), array_map('strtoupper', $return1))) {
            $return1[] = $item1;
        }

        if (!in_array(strtoupper($item2), array_map('strtoupper', $return1))) {
            $return1[] = $item2;
        }

        if (!in_array(strtoupper($item3), array_map('strtoupper', $return1))) {
            $return1[] = $item3;
        }

        $return2 = array();

        if (!in_array(strtoupper($item1), array_map('strtoupper', $return2))) {
            $return2[] = $item1;
        }

        if (!in_array(strtoupper($item2), array_map('strtoupper', $return2))) {
            $return2[] = $item2;
        }

        if (!in_array(strtoupper($item4), array_map('strtoupper', $return2))) {
            $return2[] = $item4;
        }

        $return3 = array();

        if (!in_array(strtoupper($item1), array_map('strtoupper', $return3))) {
            $return3[] = $item1;
        }

        if (!in_array(strtoupper($item3), array_map('strtoupper', $return3))) {
            $return3[] = $item3;
        }

        if (!in_array(strtoupper($item4), array_map('strtoupper', $return3))) {
            $return3[] = $item4;
        }

        $return4 = array();

        if (!in_array(strtoupper($item2), array_map('strtoupper', $return4))) {
            $return4[] = $item2;
        }

        if (!in_array(strtoupper($item3), array_map('strtoupper', $return4))) {
            $return4[] = $item3;
        }

        if (!in_array(strtoupper($item4), array_map('strtoupper', $return4))) {
            $return4[] = $item4;
        }

        if (count($return1) == 3) {
            if (!$this->is_exist_variasi_on_itemset3($return, $return1)) {
                if (!$this->is_exist_variasi_on_itemset3($array_itemset3, $return1)) {
                    $return[] = $return1;
                }
            }
        }

        if (count($return2) == 3) {
            if (!$this->is_exist_variasi_on_itemset3($return, $return2)) {
                if (!$this->is_exist_variasi_on_itemset3($array_itemset3, $return2)) {
                    $return[] = $return2;
                }
            }
        }

        if (count($return3) == 3) {
            if (!$this->is_exist_variasi_on_itemset3($return, $return3)) {
                if (!$this->is_exist_variasi_on_itemset3($array_itemset3, $return3)) {
                    $return[] = $return3;
                }
            }
        }

        if (count($return4) == 3) {
            if (!$this->is_exist_variasi_on_itemset3($return, $return4)) {
                if (!$this->is_exist_variasi_on_itemset3($array_itemset3, $return4)) {
                    $return[] = $return4;
                }
            }
        }

        return $return;
    }

    function is_exist_variasi_on_itemset3($array, $tiga_variasi)
    {
        $return = false;

        foreach ($array as $key => $value) {
            $jml = 0;
            foreach ($value as $key1 => $val1) {
                foreach ($tiga_variasi as $key2 => $val2) {
                    if (strtoupper($val1) == strtoupper($val2)) {
                        $jml++;
                    }
                }
            }
            if ($jml == 3) {
                $return = true;
                break;
            }
        }

        return $return;
    }

    function is_exist_variasi_itemset($array_item1, $array_item2, $item1, $item2)
    {
        //$return = true;

        //    $bool1 = array_search(strtoupper($item2), array_map('strtoupper', $array_item1));
        //    $bool2 = array_search(strtoupper($item1), array_map('strtoupper', $array_item2));
        //    $bool3 = array_search(strtoupper($item2), array_map('strtoupper', $array_item2));
        //    $bool4 = array_search(strtoupper($item1), array_map('strtoupper', $array_item1));
        $bool1 = array_keys(array_map('strtoupper', $array_item1), strtoupper($item1));
        $bool2 = array_keys(array_map('strtoupper', $array_item2), strtoupper($item2));
        $bool3 = array_keys(array_map('strtoupper', $array_item2), strtoupper($item1));
        $bool4 = array_keys(array_map('strtoupper', $array_item1), strtoupper($item2));

        foreach ($bool1 as $key => $value) {
            $aa = array_search($value, $bool2);

            if (is_numeric($aa)) {
                return true;
            }
        }

        foreach ($bool3 as $key => $value) {
            $aa = array_search($value, $bool4);

            if (is_numeric($aa)) {
                return true;
            }
        }

        //    if (is_numeric($bool1) && is_numeric($bool2) || is_numeric($bool3) && is_numeric($bool4)){
        //        if($bool1 === $bool2 || $bool3 === $bool4){
        //            return true;
        //        }
        //    }

        //    if (($bool3) && ($bool4)){
        //        if($bool3 == $bool4){//jika ditemukan dengan idex yg sama
        //            return true;
        //        }
        //    }

        return false;
    }

    function jumlah_itemset1($transaksi_list, $produk)
    {
        $count = 0;
        $produk_upper = strtoupper($produk);
        
        foreach ($transaksi_list as $key => $data) {
            // Use isset for faster lookup if data is preprocessed
            if (isset($data['items_array'])) {
                if (in_array($produk_upper, $data['items_array'])) {
                    $count++;
                }
            } else {
                $items = "," . strtoupper($data['produk']);
                $item_cocok = "," . $produk_upper . ",";
                if (strpos($items, $item_cocok) !== false) {
                    $count++;
                }
            }
        }

        return $count;
    }

    function jumlah_itemset2($transaksi_list, $variasi1, $variasi2)
    {
        $count = 0;
        $var1_upper = strtoupper($variasi1);
        $var2_upper = strtoupper($variasi2);

        foreach ($transaksi_list as $key => $data) {
            if (isset($data['items_array'])) {
                if (in_array($var1_upper, $data['items_array']) && in_array($var2_upper, $data['items_array'])) {
                    $count++;
                }
            } else {
                $items = "," . strtoupper($data['produk']);
                $item_variasi1 = "," . $var1_upper . ",";
                $item_variasi2 = "," . $var2_upper . ",";

                if (strpos($items, $item_variasi1) !== false && strpos($items, $item_variasi2) !== false) {
                    $count++;
                }
            }
        }

        return $count;
    }

    function jumlah_itemset3($transaksi_list, $variasi1, $variasi2, $variasi3)
    {
        $count = 0;
        $var1_upper = strtoupper($variasi1);
        $var2_upper = strtoupper($variasi2);
        $var3_upper = strtoupper($variasi3);

        foreach ($transaksi_list as $key => $data) {
            if (isset($data['items_array'])) {
                if (in_array($var1_upper, $data['items_array']) && 
                    in_array($var2_upper, $data['items_array']) && 
                    in_array($var3_upper, $data['items_array'])) {
                    $count++;
                }
            } else {
                $items = "," . strtoupper($data['produk']);
                $item_variasi1 = "," . $var1_upper . ",";
                $item_variasi2 = "," . $var2_upper . ",";
                $item_variasi3 = "," . $var3_upper . ",";

                if (strpos($items, $item_variasi1) !== false && 
                    strpos($items, $item_variasi2) !== false && 
                    strpos($items, $item_variasi3) !== false) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * kombinasi atibut1 U atribut2 => $atribut3
     * save to table confidence
     * @param type $supp_xuy
     * @param type $atribut1
     * @param type $atribut2
     * @param type $atribut3
     */

    function hitung_confidence($supp_xuy, $min_support, $min_confidence, $atribut1, $atribut2, $atribut3, $id_process, $dataTransaksi, $jumlah_transaksi)
    {

        //hitung nilai support $nilai_support_x seperti di itemset2
        $jml_itemset2 = $this->jumlah_itemset2($dataTransaksi, $atribut1, $atribut2);
        $nilai_support_x = ($jml_itemset2 / $jumlah_transaksi) * 100;

        $kombinasi1 = $atribut1 . " , " . $atribut2;
        $kombinasi2 = $atribut3;
        $supp_x = $nilai_support_x; //$row1_['support'];
        
        // Safety check to prevent division by zero
        if ($supp_x == 0) {
            return; // Skip if support is zero
        }
        
        $conf = ($supp_xuy / $supp_x) * 100;
        //lolos seleksi min confidence itemset3
        $lolos = ($conf >= $min_confidence) ? 1 : 0;

        //hitung korelasi lift
        $jumlah_kemunculanAB = $this->jumlah_itemset3($dataTransaksi, $atribut1, $atribut2, $atribut3);
        $PAUB = $jumlah_kemunculanAB / $jumlah_transaksi;

        $jumlah_kemunculanA = $this->jumlah_itemset2($dataTransaksi, $atribut1, $atribut2);
        $jumlah_kemunculanB = $this->jumlah_itemset1($dataTransaksi, $atribut3);

        //$nilai_uji_lift = $PAUB / $jumlah_kemunculanA * $jumlah_kemunculanB;
        $denominator = (($jumlah_kemunculanA / $jumlah_transaksi) * ($jumlah_kemunculanB / $jumlah_transaksi));
        $nilai_uji_lift = ($denominator > 0) ? ($PAUB / $denominator) : 0;
        $korelasi_rule = ($nilai_uji_lift < 1) ? "korelasi negatif" : "korelasi positif";

        if ($nilai_uji_lift == 1) {
            $korelasi_rule = "tidak ada korelasi";
        }

        //masukkan ke table confidence
        $data = array(
            "kombinasi1" => $kombinasi1,
            "kombinasi2" => $kombinasi2,
            "support_xUy" => $supp_xuy,
            "support_x" => $supp_x,
            "confidence" => $conf,
            "lolos" => $lolos,
            "min_support" => $min_support,
            "min_confidence" => $min_confidence,
            "nilai_uji_lift" => $nilai_uji_lift,
            "korelasi_rule" => $korelasi_rule,
            "id_process" => $id_process,
            "jumlah_a" => $jumlah_kemunculanA,
            "jumlah_b" => $jumlah_kemunculanB,
            "jumlah_ab" => $jumlah_kemunculanAB,
            "px" => ($jumlah_kemunculanA / $jumlah_transaksi),
            "py" => ($jumlah_kemunculanB / $jumlah_transaksi),
            "pxuy" => $PAUB,
            "from_itemset" => 3
        );
        $this->db->insert('confidence', $data);
    }

    /**
     * confidence atribut1 => atribut2 U atribut3
     * @param type $supp_xuy
     * @param type $min_support
     * @param type $min_confidence
     * @param type $atribut1
     * @param type $atribut2
     * @param type $atribut3
     */
    function hitung_confidence1($supp_xuy, $min_support, $min_confidence, $atribut1, $atribut2, $atribut3, $id_process, $dataTransaksi, $jumlah_transaksi)
    {

        //hitung nilai support seperti itemset1
        $jml_itemset1 = $this->jumlah_itemset1($dataTransaksi, $atribut1);
        $nilai_support_x = ($jml_itemset1 / $jumlah_transaksi) * 100;

        $kombinasi1 = $atribut1;
        $kombinasi2 = $atribut2 . " , " . $atribut3;
        $supp_x = $nilai_support_x; //$row4_['support'];
        
        // Safety check to prevent division by zero
        if ($supp_x == 0) {
            return; // Skip if support is zero
        }
        
        $conf = ($supp_xuy / $supp_x) * 100;
        //lolos seleksi min confidence itemset3
        $lolos = ($conf >= $min_confidence) ? 1 : 0;

        //hitung korelasi lift
        $jumlah_kemunculanAB = $this->jumlah_itemset3($dataTransaksi, $atribut1, $atribut2, $atribut3);
        $PAUB = $jumlah_kemunculanAB / $jumlah_transaksi;

        $jumlah_kemunculanA = $this->jumlah_itemset1($dataTransaksi, $atribut1);
        $jumlah_kemunculanB = $this->jumlah_itemset2($dataTransaksi, $atribut2, $atribut3);

        $denominator = (($jumlah_kemunculanA / $jumlah_transaksi) * ($jumlah_kemunculanB / $jumlah_transaksi));
        $nilai_uji_lift = ($denominator > 0) ? ($PAUB / $denominator) : 0;
        $korelasi_rule = ($nilai_uji_lift < 1) ? "korelasi negatif" : "korelasi positif";

        if ($nilai_uji_lift == 1) {
            $korelasi_rule = "tidak ada korelasi";
        }


        //masukkan ke table confidence
        $data = array(
            "kombinasi1" => $kombinasi1,
            "kombinasi2" => $kombinasi2,
            "support_xUy" => $supp_xuy,
            "support_x" => $supp_x,
            "confidence" => $conf,
            "lolos" => $lolos,
            "min_support" => $min_support,
            "min_confidence" => $min_confidence,
            "nilai_uji_lift" => $nilai_uji_lift,
            "korelasi_rule" => $korelasi_rule,
            "id_process" => $id_process,
            "jumlah_a" => $jumlah_kemunculanA,
            "jumlah_b" => $jumlah_kemunculanB,
            "jumlah_ab" => $jumlah_kemunculanAB,
            "px" => ($jumlah_kemunculanA / $jumlah_transaksi),
            "py" => ($jumlah_kemunculanB / $jumlah_transaksi),
            "pxuy" => $PAUB,
            "from_itemset" => 3
        );
        $this->db->insert('confidence', $data);
    }

    function hitung_confidence2($supp_xuy, $min_support, $min_confidence, $atribut1, $atribut2, $id_process, $dataTransaksi, $jumlah_transaksi)
    {
        //hitung nilai support seperti itemset1
        $jml_itemset1 = $this->jumlah_itemset1($dataTransaksi, $atribut1);
        $nilai_support_x = ($jml_itemset1 / $jumlah_transaksi) * 100;

        $kombinasi1 = $atribut1;
        $kombinasi2 = $atribut2;
        $supp_x = $nilai_support_x; //$row1_['support'];
        
        // Safety check to prevent division by zero
        if ($supp_x == 0) {
            return; // Skip if support is zero
        }
        
        $conf = ($supp_xuy / $supp_x) * 100;
        //lolos seleksi min confidence itemset3
        $lolos = ($conf >= $min_confidence) ? 1 : 0;

        //hitung korelasi lift
        $jumlah_kemunculanAB = $this->jumlah_itemset2($dataTransaksi, $atribut1, $atribut2);
        $PAUB = $jumlah_kemunculanAB / $jumlah_transaksi;

        $jumlah_kemunculanA = $this->jumlah_itemset1($dataTransaksi, $atribut1);
        $jumlah_kemunculanB = $this->jumlah_itemset1($dataTransaksi, $atribut2);

        $denominator = (($jumlah_kemunculanA / $jumlah_transaksi) * ($jumlah_kemunculanB / $jumlah_transaksi));
        $nilai_uji_lift = ($denominator > 0) ? ($PAUB / $denominator) : 0;
        $korelasi_rule = ($nilai_uji_lift < 1) ? "korelasi negatif" : "korelasi positif";

        if ($nilai_uji_lift == 1) {
            $korelasi_rule = "tidak ada korelasi";
        }

        //masukkan ke table confidence
        $data = array(
            "kombinasi1" => $kombinasi1,
            "kombinasi2" => $kombinasi2,
            "support_xUy" => $supp_xuy,
            "support_x" => $supp_x,
            "confidence" => $conf,
            "lolos" => $lolos,
            "min_support" => $min_support,
            "min_confidence" => $min_confidence,
            "nilai_uji_lift" => $nilai_uji_lift,
            "korelasi_rule" => $korelasi_rule,
            "id_process" => $id_process,
            "jumlah_a" => $jumlah_kemunculanA,
            "jumlah_b" => $jumlah_kemunculanB,
            "jumlah_ab" => $jumlah_kemunculanAB,
            "px" => ($jumlah_kemunculanA / $jumlah_transaksi),
            "py" => ($jumlah_kemunculanB / $jumlah_transaksi),
            "pxuy" => $PAUB,
            "from_itemset" => 2
        );
        $this->db->insert('confidence', $data);
    }

    public function miningProcess($min_support, $min_confidence, $start, $end)
    {
        @set_time_limit(1800); // 30 menit untuk dataset besar
        ini_set('memory_limit', '1024M'); // 1GB memory
        
        // Add process log
        $this->tambahProcessLog($min_support, $min_confidence, $start, $end);
        $id_Yuhuu = $this->getLastIdProcessLog();
        $id_process = $id_Yuhuu->last;

        // Get all transactions
        $sql = "SELECT * FROM transaksi WHERE transaction_date BETWEEN '$start' AND '$end' ORDER BY transaction_date";
        $transactions = $this->db->query($sql)->result_array();
        $total_trans = count($transactions);
        
        if ($total_trans == 0) return false;

        // Parse and organize transactions
        $dataTransaksi = array();
        $itemFreq = array();
        
        foreach ($transactions as $idx => $row) {
            $items = array_filter(array_map('trim', explode(',', $row['produk'])));
            $items = array_map('strtoupper', $items);
            $dataTransaksi[$idx] = array('tanggal' => $row['transaction_date'], 'items_array' => $items, 'produk' => $row['produk']);
            
            foreach ($items as $item) {
                $itemFreq[$item] = isset($itemFreq[$item]) ? $itemFreq[$item] + 1 : 1;
            }
        }

        // === ITEMSET 1 ===
        $itemset1 = array();
        $itemset1_insert = array();
        
        foreach ($itemFreq as $item => $count) {
            $supp = ($count / $total_trans) * 100;
            $lolos = ($supp >= $min_support) ? 1 : 0;
            $itemset1_insert[] = "('$item','$count','$supp','$lolos','$id_process')";
            if ($lolos) $itemset1[] = $item;
        }
        
        if (count($itemset1_insert) > 0) {
            $sql = "INSERT INTO itemset1 (atribut, jumlah, support, lolos, id_process) VALUES " . implode(',', $itemset1_insert);
            $this->db->query($sql);
        }
        if (count($itemset1) == 0) return false;

        // === ITEMSET 2 ===
        $itemset2 = array();
        $itemset2_insert = array();
        $pair_keys = array();
        
        // OPTIMASI: Pre-compute pair counts in single pass
        $pair_counts = array();
        foreach ($dataTransaksi as $trans) {
            $items = $trans['items_array'];
            $n = count($items);
            // Generate all pairs in this transaction
            for ($i = 0; $i < $n; $i++) {
                if (!in_array($items[$i], $itemset1)) continue; // Skip if not in frequent itemset1
                for ($j = $i + 1; $j < $n; $j++) {
                    if (!in_array($items[$j], $itemset1)) continue; // Skip if not in frequent itemset1
                    
                    $item1 = $items[$i];
                    $item2 = $items[$j];
                    
                    // Ensure consistent ordering
                    if ($item1 > $item2) {
                        $temp = $item1;
                        $item1 = $item2;
                        $item2 = $temp;
                    }
                    
                    $key = "$item1|$item2";
                    $pair_counts[$key] = isset($pair_counts[$key]) ? $pair_counts[$key] + 1 : 1;
                }
            }
        }
        
        // Now create itemset2 from pre-computed counts
        foreach ($pair_counts as $key => $count) {
            list($item1, $item2) = explode('|', $key);
            
            $supp = ($count / $total_trans) * 100;
            $lolos = ($supp >= $min_support) ? 1 : 0;
            
            // Insert ALL itemset2 (both lolos and not lolos)
            $itemset2_insert[] = "('$item1','$item2','$count','$supp','$lolos','$id_process')";
            
            if ($lolos) {
                $itemset2[] = array('item1' => $item1, 'item2' => $item2);
            }
        }
        
        // Batch insert itemset2
        if (count($itemset2_insert) > 0) {
            $batches = array_chunk($itemset2_insert, 50);
            foreach ($batches as $batch) {
                $sql = "INSERT INTO itemset2 (atribut1, atribut2, jumlah, support, lolos, id_process) VALUES " . implode(',', $batch);
                @set_time_limit(600);
                $this->db->query($sql);
            }
        }

        // === ITEMSET 3 ===
        $itemset3_insert = array();
        $itemset3_keys = array(); // Track unique itemset3 combinations
        
        // OPTIMASI: Pre-compute triplet counts in single pass
        $triplet_counts = array();
        $itemset2_items = array();
        foreach ($itemset2 as $pair) {
            $itemset2_items[] = $pair['item1'];
            $itemset2_items[] = $pair['item2'];
        }
        $itemset2_items = array_unique($itemset2_items);
        
        foreach ($dataTransaksi as $trans) {
            $items = array_intersect($trans['items_array'], $itemset2_items);
            $n = count($items);
            if ($n < 3) continue; // Skip if less than 3 items
            
            $items = array_values($items);
            // Generate all triplets in this transaction
            for ($i = 0; $i < $n; $i++) {
                for ($j = $i + 1; $j < $n; $j++) {
                    for ($k = $j + 1; $k < $n; $k++) {
                        $triplet = array($items[$i], $items[$j], $items[$k]);
                        sort($triplet);
                        $key = implode('|', $triplet);
                        $triplet_counts[$key] = isset($triplet_counts[$key]) ? $triplet_counts[$key] + 1 : 1;
                    }
                }
            }
        }
        
        // Proper Apriori: Validate triplets from itemset2 joins
        for ($i = 0; $i < count($itemset2); $i++) {
            for ($j = $i + 1; $j < count($itemset2); $j++) {
                $pair1 = $itemset2[$i];
                $pair2 = $itemset2[$j];
                
                $item1_1 = $pair1['item1'];
                $item1_2 = $pair1['item2'];
                $item2_1 = $pair2['item1'];
                $item2_2 = $pair2['item2'];
                
                // Check if pairs share exactly 1 item
                $common = array();
                
                if ($item1_1 == $item2_1 || $item1_1 == $item2_2) {
                    $common[] = $item1_1;
                }
                if ($item1_2 == $item2_1 || $item1_2 == $item2_2) {
                    $common[] = $item1_2;
                }
                
                // Must share exactly 1 item for valid itemset3
                if (count($common) == 1) {
                    $all_items = array_unique(array($item1_1, $item1_2, $item2_1, $item2_2));
                    
                    if (count($all_items) == 3) {
                        $items_set = array_values($all_items);
                        sort($items_set);
                        
                        $key = implode('|', $items_set);
                        if (isset($itemset3_keys[$key])) {
                            continue; // Skip duplicate
                        }
                        $itemset3_keys[$key] = 1;
                        
                        // Use pre-computed count
                        $count = isset($triplet_counts[$key]) ? $triplet_counts[$key] : 0;
                        $supp = ($count / $total_trans) * 100;
                        $lolos = ($supp >= $min_support) ? 1 : 0;
                        
                        // Insert ALL itemset3 (both lolos and not lolos)
                        $itemset3_insert[] = "('{$items_set[0]}','{$items_set[1]}','{$items_set[2]}','$count','$supp','$lolos','$id_process')";
                    }
                }
            }
        }
        
        // Batch insert itemset3
        if (count($itemset3_insert) > 0) {
            $batches = array_chunk($itemset3_insert, 50);
            foreach ($batches as $batch) {
                $sql = "INSERT INTO itemset3 (atribut1, atribut2, atribut3, jumlah, support, lolos, id_process) VALUES " . implode(',', $batch);
                @set_time_limit(600);
                $this->db->query($sql);
            }
        }

        // === CONFIDENCE CALCULATION ===
        // From itemset3
        $sql_3 = "SELECT * FROM itemset3 WHERE lolos = 1 AND id_process = " . $id_process;
        $itemset3_data = $this->db->query($sql_3)->result_array();
        
        foreach ($itemset3_data as $row) {
            $this->hitung_confidence($row['support'], $min_support, $min_confidence, $row['atribut1'], $row['atribut2'], $row['atribut3'], $id_process, $dataTransaksi, $total_trans);
            $this->hitung_confidence($row['support'], $min_support, $min_confidence, $row['atribut2'], $row['atribut3'], $row['atribut1'], $id_process, $dataTransaksi, $total_trans);
            $this->hitung_confidence($row['support'], $min_support, $min_confidence, $row['atribut3'], $row['atribut1'], $row['atribut2'], $id_process, $dataTransaksi, $total_trans);
            $this->hitung_confidence1($row['support'], $min_support, $min_confidence, $row['atribut1'], $row['atribut3'], $row['atribut2'], $id_process, $dataTransaksi, $total_trans);
            $this->hitung_confidence1($row['support'], $min_support, $min_confidence, $row['atribut2'], $row['atribut1'], $row['atribut3'], $id_process, $dataTransaksi, $total_trans);
            $this->hitung_confidence1($row['support'], $min_support, $min_confidence, $row['atribut3'], $row['atribut2'], $row['atribut1'], $id_process, $dataTransaksi, $total_trans);
        }
        
        // From itemset2
        $sql_2 = "SELECT * FROM itemset2 WHERE lolos = 1 AND id_process = " . $id_process;
        $itemset2_data = $this->db->query($sql_2)->result_array();
        
        foreach ($itemset2_data as $row) {
            $this->hitung_confidence2($row['support'], $min_support, $min_confidence, $row['atribut1'], $row['atribut2'], $id_process, $dataTransaksi, $total_trans);
            $this->hitung_confidence2($row['support'], $min_support, $min_confidence, $row['atribut2'], $row['atribut1'], $id_process, $dataTransaksi, $total_trans);
        }
        
        return true;
    }

    function data_transaksi()
    {
        $this->db->select('*');
        $this->db->from('transaksi');

        return $this->db->get()->num_rows();
    }

    function hasil_proses()
    {
        $this->db->select('*');
        $this->db->from('process_log');

        return $this->db->get()->num_rows();
    }

    function jumlah_user()
    {
        $this->db->select('*');
        $this->db->from('user');

        return $this->db->get()->num_rows();
    }

    function nama_role()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        $this->db->where('id !=');

        return $this->db->get()->row_array();
    }

    // Database Cleanup Functions
    public function getCleanupStats()
    {
        $stats = array();
        
        // Count records in each table
        $stats['process_log'] = $this->db->count_all('process_log');
        $stats['itemset1'] = $this->db->count_all('itemset1');
        $stats['itemset2'] = $this->db->count_all('itemset2');
        $stats['itemset3'] = $this->db->count_all('itemset3');
        $stats['confidence'] = $this->db->count_all('confidence');
        $stats['transaksi'] = $this->db->count_all('transaksi');
        
        // Get table sizes
        $sql = "SELECT 
            table_name,
            ROUND((data_length + index_length) / 1024 / 1024, 2) AS size_mb
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
            AND table_name IN ('process_log', 'itemset1', 'itemset2', 'itemset3', 'confidence', 'transaksi')
            ORDER BY (data_length + index_length) DESC";
        
        $sizes = $this->db->query($sql)->result_array();
        $stats['sizes'] = array();
        foreach ($sizes as $size) {
            $stats['sizes'][$size['table_name']] = $size['size_mb'];
        }
        
        return $stats;
    }

    public function getProcessList()
    {
        $sql = "SELECT 
            pl.id,
            pl.process_id,
            pl.start_date,
            pl.end_date,
            pl.min_support,
            pl.min_confidence,
            (SELECT COUNT(*) FROM confidence WHERE id_process = pl.id) as rules_count,
            (SELECT COUNT(*) FROM itemset1 WHERE id_process = pl.id) as itemset1_count,
            (SELECT COUNT(*) FROM itemset2 WHERE id_process = pl.id) as itemset2_count,
            (SELECT COUNT(*) FROM itemset3 WHERE id_process = pl.id) as itemset3_count
            FROM process_log pl
            ORDER BY pl.id DESC";
        
        return $this->db->query($sql)->result_array();
    }

    public function deleteProcessData($id)
    {
        // Start transaction
        $this->db->trans_start();
        
        // Delete related data
        $this->db->where('id_process', $id);
        $this->db->delete('confidence');
        
        $this->db->where('id_process', $id);
        $this->db->delete('itemset3');
        
        $this->db->where('id_process', $id);
        $this->db->delete('itemset2');
        
        $this->db->where('id_process', $id);
        $this->db->delete('itemset1');
        
        // Delete process log
        $this->db->where('id', $id);
        $this->db->delete('process_log');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function deleteOldProcesses($keep_latest)
    {
        // Get IDs to keep
        $sql = "SELECT id FROM process_log ORDER BY id DESC LIMIT " . (int)$keep_latest;
        $keep_ids = $this->db->query($sql)->result_array();
        
        if (empty($keep_ids)) {
            return false;
        }
        
        $keep_ids_array = array_column($keep_ids, 'id');
        
        // Start transaction
        $this->db->trans_start();
        
        // Delete from confidence
        $this->db->where_not_in('id_process', $keep_ids_array);
        $this->db->delete('confidence');
        
        // Delete from itemset3
        $this->db->where_not_in('id_process', $keep_ids_array);
        $this->db->delete('itemset3');
        
        // Delete from itemset2
        $this->db->where_not_in('id_process', $keep_ids_array);
        $this->db->delete('itemset2');
        
        // Delete from itemset1
        $this->db->where_not_in('id_process', $keep_ids_array);
        $this->db->delete('itemset1');
        
        // Delete from process_log
        $this->db->where_not_in('id', $keep_ids_array);
        $this->db->delete('process_log');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function deleteAllProcessData()
    {
        // Start transaction
        $this->db->trans_start();
        
        // Truncate all tables
        $this->db->truncate('confidence');
        $this->db->truncate('itemset3');
        $this->db->truncate('itemset2');
        $this->db->truncate('itemset1');
        $this->db->truncate('process_log');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
}

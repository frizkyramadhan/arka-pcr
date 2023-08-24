<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Unit extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/process_login');
        } else {
            $this->load->model('unit_m');
            $this->load->model('login_m');
            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        }
    }

    function index()
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);

        //pagination setting
        $config['base_url'] = site_url('unit/index');
        if ($pengguna->kode_project == '000H') {
            $config['total_rows'] = $this->db->count_all('unit');
        } else {
            $config['total_rows'] = $this->unit_m->countByProject();
        }
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;

        // integrate bootstrap pagination
        $config['cur_tag_open'] = '<b class="btn btn-info">';
        $config['cur_tag_close'] = '</b>';
        $config['anchor_class'] = 'class="btn"';

        $this->pagination->initialize($config);

        if ($pengguna->kode_project == '000H') {
            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['unitlist'] = $this->unit_m->get_unit($config["per_page"], $data['page'], NULL);
        } else {
            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['unitlist'] = $this->unit_m->selectAllByProject($config["per_page"], $data['page'], NULL);
        }

        $this->load->view('unit/unit', $data);
        $this->load->view('footer');
    }

    function search()
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);

        // get search string
        $search = ($this->input->post("search")) ? $this->input->post("search") : "NIL";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("unit/search/$search");
        if ($pengguna->kode_project == '000H') {
            $config['total_rows'] = $this->unit_m->searchUnit($search);
        } else {
            $config['total_rows'] = $this->unit_m->searchUnitByProject($search);
        }
        $config['per_page'] = 30;
        $config["uri_segment"] = 4;

        // integrate bootstrap pagination
        $config['cur_tag_open'] = '<b class="btn btn-info">';
        $config['cur_tag_close'] = '</b>';
        $config['anchor_class'] = 'class="btn"';

        $this->pagination->initialize($config);

        if ($pengguna->kode_project == '000H') {
            $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $data['unitlist'] = $this->unit_m->get_unit($config['per_page'], $data['page'], $search);
        } else {
            $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $data['unitlist'] = $this->unit_m->selectAllByProject($config["per_page"], $data['page'], $search);
        }

        //load view
        $this->load->view('unit/unit', $data);
        $this->load->view('footer');
    }

    function add()
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        //penentuan dropdown model
        $dbres_mod = $this->db->query('select * from model order by model_no asc');
        $ddmenu_mod = array();
        foreach ($dbres_mod->result_array() as $tablerow) {
            $ddmenu_mod[$tablerow['id_model']] = $tablerow['model_no'];
        }
        $data['model_options'] = $ddmenu_mod;

        //penentuan dropdown project
        $dbres_proj = $this->db->query('select * from project order by kode_project asc');
        $ddmenu_proj = array();
        foreach ($dbres_proj->result_array() as $tablerow) {
            $ddmenu_proj[$tablerow['id_project']] = $tablerow['kode_project'];
        }
        $data['proj_options'] = $ddmenu_proj;

        $this->form_validation->set_rules('unit_no', 'Unit No.', 'required|is_unique[unit.unit_no]', ['is_unique' => 'This Unit No is already registered']);

        if ($this->form_validation->run() == false) {
            $this->load->view('unit/add_unit', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert($_POST);
            redirect('unit');
        }
    }

    function delete($id)
    {
        $this->unit_m->delete($id);
        redirect('unit');
    }

    function edit($id)
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        //penentuan dropdown model
        $dbres_mod = $this->db->query('select * from model order by model_no asc');
        $ddmenu_mod = array();
        foreach ($dbres_mod->result_array() as $tablerow) {
            $ddmenu_mod[$tablerow['id_model']] = $tablerow['model_no'];
        }
        $data['model_options'] = $ddmenu_mod;

        //penentuan dropdown project
        $dbres_proj = $this->db->query('select * from project order by kode_project asc');
        $ddmenu_proj = array();
        foreach ($dbres_proj->result_array() as $tablerow) {
            $ddmenu_proj[$tablerow['id_project']] = $tablerow['kode_project'];
        }
        $data['proj_options'] = $ddmenu_proj;

        if ($_POST == NULL) {
            $data['unit'] = $this->unit_m->select($id);
            $data['select_model'] = $this->unit_m->select_model($id);
            $data['select_project'] = $this->unit_m->select_project($id);
            $this->load->view('unit/edit_unit', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->update($id);
            redirect('unit/detail/' . $id);
        }
    }

    function detail($id)
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['unit'] = $this->unit_m->select($id);
        $data['comp'] = $this->unit_m->get_comp($id);
        $this->load->view('unit/detail', $data);
        $this->load->view('footer');
    }



    function replacement($id, $id_mod)
    {
        $data['title'] = "Replacement Detail - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['reps'] = $this->unit_m->select_reps($id, $id_mod);
        $data['count'] = $this->unit_m->num_reps($id, $id_mod);
        $data['avg'] = $this->unit_m->getAvg($id);

        $reps = $this->unit_m->select_reps_asc($id, $id_mod);
        $count = $this->unit_m->num_reps($id, $id_mod);
        if ($count > 0) {
            $data['last_rep'] = $reps[$count - 1];
        } else {
            $data['last_rep'] = $reps;
        }

        $data['hm'] = $this->unit_m->select_hm($id);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);
        $data['last'] = $this->unit_m->last_rep($id, $id_mod);
        $data['last_rep_close'] = $this->unit_m->last_rep_close($id, $id_mod);
        $this->load->view('unit/replacement', $data);
        $this->load->view('footer');
    }

    function add_replacement($id, $id_mod)
    {
        $data['title'] = "Replacement Detail - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $reps = $this->unit_m->select_reps_asc($id, $id_mod);
        $count = $this->unit_m->num_reps($id, $id_mod);
        if ($count > 0) {
            $data['last_rep'] = $reps[$count - 1];
        } else {
            $data['last_rep'] = $reps;
        }
        $data['hm'] = $this->unit_m->select_hm($id);
        $data['avg'] = $this->unit_m->getAvg($id);
        $data['last_rep_close'] = $this->unit_m->last_rep_close($id, $id_mod);
        if ($_POST == NULL) {
            $data['rep'] = $this->unit_m->select_mod($id, $id_mod);
            $data['last'] = $this->unit_m->last_rep($id, $id_mod);
            $this->load->view('unit/add_rep', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_rep($_POST);
            redirect('unit/replacement/' . $id . '/' . $id_mod);
        }
    }

    function edit_replacement($id, $id_unit, $id_mod)
    {
        $data['title'] = "Replacement Detail - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $reps = $this->unit_m->select_reps_asc($id_unit, $id_mod);
        $count = $this->unit_m->num_reps($id_unit, $id_mod);
        if ($count > 0) {
            $data['last_rep'] = $reps[$count - 1];
        } else {
            $data['last_rep'] = $reps;
        }
        $data['hm'] = $this->unit_m->select_hm($id_unit);
        $data['avg'] = $this->unit_m->getAvg($id);
        $data['last_rep_close'] = $this->unit_m->last_rep_close($id_unit, $id_mod);
        if ($_POST == NULL) {
            $data['rep'] = $this->unit_m->get_rep($id, $id_unit, $id_mod);
            $data['last'] = $this->unit_m->last_rep($id_unit, $id_mod);
            $data['sel_stat'] = $this->unit_m->select_status($id);
            $this->load->view('unit/edit_rep', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_rep($id);
            redirect('unit/replacement/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_replacement($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_replacement($id);
        redirect('unit/replacement/' . $id_unit . '/' . $id_mod);
    }

    function close_replacement($id, $id_unit, $id_mod)
    {
        $hm = $this->unit_m->select_hm($id_unit);
        $rep = $this->unit_m->get_rep($id);
        $last = $this->unit_m->last_rep($id_unit, $id_mod);

        //$a = $rep->hm_rep; 
        $a = $hm->hm_unit;
        //$b = $last->hm_unit; //diaktifkan saat replacement sudah berjalan
        $b = $rep->last_hm_rep; //dinonaktifkan saat replacement sudah berjalan
        $c = $rep->comp_hour;
        $policy = $rep->policy;
        $comp_life = ($a - $b) + $c;
        $life = ($comp_life / $policy) * 100;
        $round = round($life, 1);

        $this->db->set('hm_rep', $a);
        $this->db->set('last_hm_rep', $b);
        $this->db->set('comp_life', $comp_life);
        $this->db->set('life_percent', $round);
        $this->db->set('wo_status', 'CLOSE');
        $this->db->where('id_rep', $id);
        $this->db->update('replacement');


        $this->db->set('id_unit', $id_unit);
        $this->db->set('id_mod', $id_mod);
        $this->db->set('hm_rep', $hm->hm_unit);
        $this->db->set('last_hm_rep', $rep->hm_rep);
        $this->db->set('last_rep_date', $rep->wo_end_date);
        $this->db->set('wo_status', 'OPEN');
        $this->db->set('comp_hour', 0);
        $this->db->set('comp_cond', 'NORMAL');
        $this->db->insert('replacement');

        redirect('unit/replacement/' . $id_unit . '/' . $id_mod);
    }

    public function export_pcr($id, $id_mod)
    {
        $reps = $this->unit_m->select_reps($id, $id_mod);
        $avg = $this->unit_m->getAvg($id);

        if (count($reps) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Planned Component Replacement - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:R3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S");

            $val = array("Site", "Manufacture", "Model", "Unit No.", "Component Description", "Policy", "% Life", "Comp Life", "Comp Condition", "HM Now", "WH/Day", "Work Order", "WO Schedule Date", "WO Status", "WO Complete Date", "Installed Comp Hrs", "Last Replacement HM", "Last Replacement Date", "Next Replacement Date");

            $objset->setCellValue("A" . "1", "ARKA Planned Component Replacement");
            //            $objset->setCellValue("A"."3", "Last Replacement HM");
            //            $objset->setCellValue("A"."4", "Last Replacement Date");
            //            $objset->setCellValue("A"."5", "Next Replacement Date");
            //            $objset->setCellValue("B"."3", $last->hm_unit);
            //            $objset->setCellValue("B"."4", $last->rep_date);
            //            $objset->setCellValue("B"."5", $next_date);

            for ($a = 0; $a < 19; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(22);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(22);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(22);
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(22);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $baris  = 4;
            foreach ($reps as $row) {
                $hm_rep = $row['hm_rep'];
                $l_hm = $row['last_hm_rep'];
                $ich = $row['comp_hour'];
                $comp_life = ($hm_rep - $l_hm) + $ich;
                $policy = $row['policy'];
                $life = ($comp_life / $policy) * 100;
                $wh_day = round($avg->avg, 1);
                $date = date('Y-m-d');
                if ($wh_day == 0) {
                    $forecast = 0;
                } else {
                    $forecast = round(($policy - $comp_life) / $wh_day, 0);
                }
                $next = date('Y-m-d', strtotime($date . '+' . $forecast . 'days'));

                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $row['kode_project']);
                $objset->setCellValue("B" . $baris, $row['manufacture']);
                $objset->setCellValue("C" . $baris, $row['model_no']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['description']);
                $objset->setCellValue("F" . $baris, $row['policy']);
                $objset->setCellValue("G" . $baris, round($life, 1) . "%");
                $objset->setCellValue("H" . $baris, $comp_life);
                $objset->setCellValue("I" . $baris, $row['comp_cond']);
                $objset->setCellValue("J" . $baris, $row['hm_rep']);
                $objset->setCellValue("K" . $baris, $wh_day);
                $objset->setCellValue("L" . $baris, $row['wo_no']);
                $objset->setCellValue("M" . $baris, $row['wo_date']);
                $objset->setCellValue("N" . $baris, $row['wo_status']);
                $objset->setCellValue("O" . $baris, $row['wo_end_date']);
                $objset->setCellValue("P" . $baris, $row['comp_hour']);
                $objset->setCellValue("Q" . $baris, $row['last_hm_rep']);
                $objset->setCellValue("R" . $baris, $row['last_rep_date']);
                $objset->setCellValue("S" . $baris, $next);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-PCR-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/replacement/' . $id . '/' . $id_mod);
        }
    }

    function import()
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        if ($this->input->post('save')) {
            $fileName = $_FILES['import']['name'];

            $config['upload_path'] = './assets/file/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size']        = 10000;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('import'))
                $this->upload->display_errors();

            $media = $this->upload->data('import');
            $inputFileName = './assets/file/' . $media['file_name'];

            //  Read your Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE
                );
                //  Insert row data array into your database of choice here
                $data = array(
                    "id_unit" => $rowData[0][0],
                    "unit_no" => $rowData[0][1],
                    "unit_desc" => $rowData[0][2],
                    "id_model" => $rowData[0][3],
                    "id_project" => $rowData[0][4],
                    "sn_unit" => $rowData[0][5]
                );

                $this->db->insert("unit", $data);
                delete_files($media['file_path']);
            }
            echo "Import Success";
        }
        $this->load->view('unit/import', $data);
        $this->load->view('footer');
    }

    function upload_hm()
    {
        $data['title'] = "Unit List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $hm = $this->db->query('select * from hm')->result_array();

        if ($this->input->post('save')) {
            $fileName = $_FILES['import']['name'];

            $config['upload_path'] = './assets/file/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size']        = 10000;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('import'))
                $this->upload->display_errors();

            $media = $this->upload->data('import');
            $inputFileName = './assets/file/' . $media['file_name'];

            //  Read your Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE
                );
                //  Insert row data array into your database of choice here
                $data = array(
                    "id_unit" => $rowData[0][0],
                    "hm_unit" => $rowData[0][1],
                    "wh_day" => $rowData[0][2],
                    "date_hm" => $rowData[0][3]
                );

                //                foreach ($hm as $h){
                //                    if ($h->id_unit == $data['id_unit'] && $h->date_hm == $data['date_hm']){
                //                        $this->db->update('hm',$data,array('id_unit'=>$h->id_unit, 'date_hm'=>$h->date_hm));
                //                    } else {
                //                        $this->db->insert("hm",$data);
                //                    }
                //                }



                $this->db->insert("hm", $data);
                delete_files($media['file_path']);
            }
            echo "Upload Success";
        }

        $this->load->view('unit/upload', $data);
        $this->load->view('footer');
    }

    public function download_hm()
    {
        $hm = $this->unit_m->getHM();

        if (count($hm) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Planned Component Replacement - HM Unit");  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:E3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E");

            $val = array("Id Unit", "Unit No", "HM Unit", "WH / Day", "Last HM Date");

            $objset->setCellValue("A" . "1", "ARKA Planned Component Replacement - HM Unit");

            for ($a = 0; $a < 5; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);


                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $baris  = 4;
            foreach ($hm as $row) {

                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $row['id_unit']);
                $objset->setCellValue("B" . $baris, $row['unit_no']);
                $objset->setCellValue("C" . $baris, $row['hm_unit']);
                $objset->setCellValue("D" . $baris, $row['wh_day']);
                $objset->setCellValue("E" . $baris, $row['last_hm_date']);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-PCR-HM-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit');
        }
    }

    function truncate()
    {
        $this->db->truncate('unit');
        redirect('unit/import');
    }

    function truncate_hm()
    {
        $this->db->truncate('hm');
        redirect('unit/import');
    }



    function sos($id, $id_mod)
    {
        $data['title'] = "Scheduled Oil Sampling Detail - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['sos'] = $this->unit_m->select_sos($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        $this->load->view('unit/sos', $data);
        $this->load->view('footer');
    }

    function add_sos($id, $id_mod)
    {
        $data['title'] = "Scheduled Oil Sampling Detail - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        if ($_POST == NULL) {
            $this->load->view('unit/add_sos', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_sos($_POST);
            redirect('unit/sos/' . $id . '/' . $id_mod);
        }
    }

    function edit_sos($id, $id_unit, $id_mod)
    {
        $data['title'] = "Scheduled Oil Sampling Detail - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id_unit, $id_mod);

        if ($_POST == NULL) {
            $data['sos'] = $this->unit_m->get_sos($id);
            $data['select_code'] = $this->unit_m->select_code($id);
            $this->load->view('unit/edit_sos', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_sos($id);
            redirect('unit/sos/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_sos($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_sos($id);
        redirect('unit/sos/' . $id_unit . '/' . $id_mod);
    }

    function export_sos($id, $id_mod)
    {
        $sos = $this->unit_m->select_sos($id, $id_mod);

        if (count($sos) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Scheduled Oil Sampling - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:AU3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU");

            $val = array(
                "Lab Name", "Lab No", "Sample Date", "Unit No.", "Model", "Component", "Oil Type", "Hrs Oil", "Hrs Unit", "Evaluation Code", "Recommendation", "Oil Change", "Oil Added",
                "Fe", "Cu", "Cr", "Si", "Al", "Ni", "Sn", "Pb", "PQ", "Soot", "Oxid", "Nitr", "SOX", "4um", "6um", "14um", "15um", "ISO4406", "ISO.14", "ISO.6", "Ca", "Zn", "Mo", "Bo", "P", "Na", "K", "Mg", "Visc", "TBN", "TAN", "Gly", "Water", "Dilution"
            );

            $objset->setCellValue("A" . "1", "ARKA Scheduled Oil Sampling");

            for ($a = 0; $a < 47; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(8);


                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff0000')));

            $baris  = 4;
            foreach ($sos as $row) {
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $row['lab_name']);
                $objset->setCellValue("B" . $baris, $row['lab_no']);
                $objset->setCellValue("C" . $baris, $row['sample_date']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['model_no']);
                $objset->setCellValue("F" . $baris, $row['comp_desc']);
                $objset->setCellValue("G" . $baris, $row['oil_type']);
                $objset->setCellValue("H" . $baris, $row['h_oil']);
                $objset->setCellValue("I" . $baris, $row['h_unit']);
                if ($row['eval_code'] == "A" || $row['eval_code'] == "Normal") {
                    $objset->setCellValue("J" . $baris, $row['eval_code'])->getStyle("J" . $baris)->applyFromArray($green);
                } elseif ($row['eval_code'] == "B" || $row['eval_code'] == "Attention") {
                    $objset->setCellValue("J" . $baris, $row['eval_code'])->getStyle("J" . $baris)->applyFromArray($yellow);
                } elseif ($row['eval_code'] == "C" || $row['eval_code'] == "D") {
                    $objset->setCellValue("J" . $baris, $row['eval_code'])->getStyle("J" . $baris)->applyFromArray($orange);
                } elseif ($row['eval_code'] == "X" || $row['eval_code'] == "Urgent") {
                    $objset->setCellValue("J" . $baris, $row['eval_code'])->getStyle("J" . $baris)->applyFromArray($red);
                }
                $objset->setCellValue("J" . $baris, $row['eval_code']);
                $objset->setCellValue("K" . $baris, $row['recommendation']);
                $objset->setCellValue("L" . $baris, $row['oil_change']);
                $objset->setCellValue("M" . $baris, $row['oil_added']);
                $objset->setCellValue("N" . $baris, $row['fe']);
                $objset->setCellValue("O" . $baris, $row['cu']);
                $objset->setCellValue("P" . $baris, $row['cr']);
                $objset->setCellValue("Q" . $baris, $row['si']);
                $objset->setCellValue("R" . $baris, $row['al']);
                $objset->setCellValue("S" . $baris, $row['ni']);
                $objset->setCellValue("T" . $baris, $row['sn']);
                $objset->setCellValue("U" . $baris, $row['pb']);
                $objset->setCellValue("V" . $baris, $row['pq']);
                $objset->setCellValue("W" . $baris, $row['soot']);
                $objset->setCellValue("X" . $baris, $row['oxid']);
                $objset->setCellValue("Y" . $baris, $row['nitr']);
                $objset->setCellValue("Z" . $baris, $row['sox']);
                $objset->setCellValue("AA" . $baris, $row['4um']);
                $objset->setCellValue("AB" . $baris, $row['6um']);
                $objset->setCellValue("AC" . $baris, $row['14um']);
                $objset->setCellValue("AD" . $baris, $row['15um']);
                $objset->setCellValue("AE" . $baris, $row['iso4406']);
                $objset->setCellValue("AF" . $baris, $row['iso14']);
                $objset->setCellValue("AG" . $baris, $row['iso6']);
                $objset->setCellValue("AH" . $baris, $row['ca']);
                $objset->setCellValue("AI" . $baris, $row['zn']);
                $objset->setCellValue("AJ" . $baris, $row['mo']);
                $objset->setCellValue("AK" . $baris, $row['bo']);
                $objset->setCellValue("AL" . $baris, $row['p']);
                $objset->setCellValue("AM" . $baris, $row['na']);
                $objset->setCellValue("AN" . $baris, $row['k']);
                $objset->setCellValue("AO" . $baris, $row['mg']);
                $objset->setCellValue("AP" . $baris, $row['visc']);
                $objset->setCellValue("AQ" . $baris, $row['tbn']);
                $objset->setCellValue("AR" . $baris, $row['tan']);
                $objset->setCellValue("AS" . $baris, $row['gly']);
                $objset->setCellValue("AT" . $baris, $row['water']);
                $objset->setCellValue("AU" . $baris, $row['dilution']);


                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-SOS-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/sos/' . $id . '/' . $id_mod);
        }
    }

    function import_sos()
    {
        $data['title'] = "Import SOS - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        if ($this->input->post('save')) {
            $fileName = $_FILES['import']['name'];

            $config['upload_path'] = './assets/file/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size']        = 10000;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('import'))
                $this->upload->display_errors();

            $media = $this->upload->data('import');
            $inputFileName = './assets/file/' . $media['file_name'];

            //  Read your Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE
                );
                //  Insert row data array into your database of choice here
                $data = array(
                    "id_sos" => $rowData[0][1],
                    "id_unit" => $rowData[0][2],
                    "id_mod" => $rowData[0][3],
                    "lab_name" => $rowData[0][4],
                    "lab_no" => $rowData[0][5],
                    "sample_date" => $rowData[0][6],
                    "oil_type" => $rowData[0][7],
                    "h_oil" => $rowData[0][8],
                    "h_unit" => $rowData[0][9],
                    "eval_code" => $rowData[0][10],
                    "recommendation" => $rowData[0][11],
                    "oil_change" => $rowData[0][12],
                    "oil_added" => $rowData[0][13],
                    "visc" => $rowData[0][14],
                    "tbn" => $rowData[0][15],
                    "tan" => $rowData[0][16],
                    "mg" => $rowData[0][17],
                    "ca" => $rowData[0][18],
                    "zn" => $rowData[0][19],
                    "mo" => $rowData[0][20],
                    "bo" => $rowData[0][21],
                    "p" => $rowData[0][22],
                    "na" => $rowData[0][23],
                    "k" => $rowData[0][24],
                    "si" => $rowData[0][25],
                    "dilution" => $rowData[0][26],
                    "water" => $rowData[0][27],
                    "gly" => $rowData[0][28],
                    "fe" => $rowData[0][29],
                    "cu" => $rowData[0][30],
                    "al" => $rowData[0][31],
                    "cr" => $rowData[0][32],
                    "ni" => $rowData[0][33],
                    "sn" => $rowData[0][34],
                    "pb" => $rowData[0][35],
                    "pq" => $rowData[0][36],
                    "soot" => $rowData[0][37],
                    "oxid" => $rowData[0][38],
                    "nitr" => $rowData[0][39],
                    "sox" => $rowData[0][40],
                    "4um" => $rowData[0][41],
                    "6um" => $rowData[0][42],
                    "14um" => $rowData[0][43],
                    "15um" => $rowData[0][44],
                    "iso4406" => $rowData[0][45],
                    "iso14" => $rowData[0][46],
                    "iso6" => $rowData[0][47]
                );

                $this->db->insert("sos", $data);
                delete_files($media['file_path']);
            }
            echo "Import Success";
        }
        $this->load->view('unit/import_sos', $data);
        $this->load->view('footer');
    }



    function filter_cut($id, $id_mod)
    {
        $data['title'] = "Filter Cut Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['filter'] = $this->unit_m->select_ins_f($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        $this->load->view('unit/filter', $data);
        $this->load->view('footer');
    }

    function add_inspection_f($id, $id_mod)
    {
        $data['title'] = "Filter Cut Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        if ($_POST == NULL) {
            $this->load->view('unit/add_ins_f', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_ins($_POST);
            redirect('unit/filter_cut/' . $id . '/' . $id_mod);
        }
    }

    function edit_inspection_f($id, $id_unit, $id_mod)
    {
        $data['title'] = "Filter Cut Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id_unit, $id_mod);
        $data['select_rating'] = $this->unit_m->select_rating($id);

        if ($_POST == NULL) {
            $data['filter'] = $this->unit_m->get_ins_f($id);
            $this->load->view('unit/edit_ins_f', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_ins($id);
            redirect('unit/filter_cut/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_inspection_f($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_ins($id);
        redirect('unit/filter_cut/' . $id_unit . '/' . $id_mod);
    }

    function export_inspection_f($id, $id_mod)
    {
        $sql = $this->unit_m->select_ins_f($id, $id_mod);

        if (count($sql) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Component Inspection - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:I3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");

            $val = array("No", "Site", "Inspection Date", "Unit No.", "Model", "Component", "Hour Meter", "Rating", "Type");

            $objset->setCellValue("A" . "1", "ARKA Component Inspection");

            for ($a = 0; $a < 9; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff0000')));

            $baris  = 4;
            $i = 1;
            foreach ($sql as $row) {
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $i++);
                $objset->setCellValue("B" . $baris, $row['kode_project']);
                $objset->setCellValue("C" . $baris, $row['ins_date']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['model_no']);
                $objset->setCellValue("F" . $baris, $row['comp_desc']);
                $objset->setCellValue("G" . $baris, $row['ins_hm']);
                if ($row['rating'] == "A") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($green);
                } elseif ($row['rating'] == "B") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($yellow);
                } elseif ($row['rating'] == "C") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($orange);
                } elseif ($row['rating'] == "X") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($red);
                }
                $objset->setCellValue("I" . $baris, $row['type']);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-INS-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/filter_cut/' . $id . '/' . $id_mod);
        }
    }

    function magnetic_plug_screen($id, $id_mod)
    {
        $data['title'] = "Magnetic Plug/Screen Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['magnetic'] = $this->unit_m->select_ins_m($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        $this->load->view('unit/magnetic', $data);
        $this->load->view('footer');
    }

    function add_inspection_m($id, $id_mod)
    {
        $data['title'] = "Magnetic Plug/Screen Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        if ($_POST == NULL) {
            $this->load->view('unit/add_ins_m', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_ins($_POST);
            redirect('unit/magnetic_plug_screen/' . $id . '/' . $id_mod);
        }
    }

    function edit_inspection_m($id, $id_unit, $id_mod)
    {
        $data['title'] = "Magnetic Plug/Screen Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id_unit, $id_mod);
        $data['select_rating'] = $this->unit_m->select_rating($id);

        if ($_POST == NULL) {
            $data['magnetic'] = $this->unit_m->get_ins_m($id);
            $this->load->view('unit/edit_ins_m', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_ins($id);
            redirect('unit/magnetic_plug_screen/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_inspection_m($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_ins($id);
        redirect('unit/magnetic_plug_screen/' . $id_unit . '/' . $id_mod);
    }

    function export_inspection_m($id, $id_mod)
    {
        $sql = $this->unit_m->select_ins_m($id, $id_mod);

        if (count($sql) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Component Inspection - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:I3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");

            $val = array("No", "Site", "Inspection Date", "Unit No.", "Model", "Component", "Hour Meter", "Rating", "Type");

            $objset->setCellValue("A" . "1", "ARKA Component Inspection");

            for ($a = 0; $a < 9; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff0000')));

            $baris  = 4;
            $i = 1;
            foreach ($sql as $row) {
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $i++);
                $objset->setCellValue("B" . $baris, $row['kode_project']);
                $objset->setCellValue("C" . $baris, $row['ins_date']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['model_no']);
                $objset->setCellValue("F" . $baris, $row['comp_desc']);
                $objset->setCellValue("G" . $baris, $row['ins_hm']);
                if ($row['rating'] == "A") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($green);
                } elseif ($row['rating'] == "B") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($yellow);
                } elseif ($row['rating'] == "C") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($orange);
                } elseif ($row['rating'] == "X") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($red);
                }
                $objset->setCellValue("I" . $baris, $row['type']);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-INS-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/magnetic_plug_screen/' . $id . '/' . $id_mod);
        }
    }

    function visual_inspection($id, $id_mod)
    {
        $data['title'] = "Visual Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['visual'] = $this->unit_m->select_ins_v($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        $this->load->view('unit/visual', $data);
        $this->load->view('footer');
    }

    function add_inspection_v($id, $id_mod)
    {
        $data['title'] = "Visual Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        if ($_POST == NULL) {
            $this->load->view('unit/add_ins_v', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_ins($_POST);
            redirect('unit/visual_inspection/' . $id . '/' . $id_mod);
        }
    }

    function edit_inspection_v($id, $id_unit, $id_mod)
    {
        $data['title'] = "Visual Inspection - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id_unit, $id_mod);
        $data['select_rating'] = $this->unit_m->select_rating($id);

        if ($_POST == NULL) {
            $data['visual'] = $this->unit_m->get_ins_v($id);
            $this->load->view('unit/edit_ins_v', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_ins($id);
            redirect('unit/visual_inspection/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_inspection_v($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_ins($id);
        redirect('unit/visual_inspection/' . $id_unit . '/' . $id_mod);
    }

    function export_inspection_v($id, $id_mod)
    {
        $sql = $this->unit_m->select_ins_v($id, $id_mod);

        if (count($sql) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Component Inspection - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:I3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");

            $val = array("No", "Site", "Inspection Date", "Unit No.", "Model", "Component", "Hour Meter", "Rating", "Type");

            $objset->setCellValue("A" . "1", "ARKA Component Inspection");

            for ($a = 0; $a < 9; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff0000')));

            $baris  = 4;
            $i = 1;
            foreach ($sql as $row) {
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $i++);
                $objset->setCellValue("B" . $baris, $row['kode_project']);
                $objset->setCellValue("C" . $baris, $row['ins_date']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['model_no']);
                $objset->setCellValue("F" . $baris, $row['comp_desc']);
                $objset->setCellValue("G" . $baris, $row['ins_hm']);
                if ($row['rating'] == "A") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($green);
                } elseif ($row['rating'] == "B") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($yellow);
                } elseif ($row['rating'] == "C") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($orange);
                } elseif ($row['rating'] == "X") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($red);
                }
                $objset->setCellValue("I" . $baris, $row['type']);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-INS-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/visual_inspection/' . $id . '/' . $id_mod);
        }
    }

    function ta2($id, $id_mod)
    {
        $data['title'] = "Technical Analysis 2 - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['ta2'] = $this->unit_m->select_ins_t($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        $this->load->view('unit/ta2', $data);
        $this->load->view('footer');
    }

    function add_inspection_t($id, $id_mod)
    {
        $data['title'] = "Technical Analysis 2 - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        if ($_POST == NULL) {
            $this->load->view('unit/add_ins_t', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_ins($_POST);
            redirect('unit/ta2/' . $id . '/' . $id_mod);
        }
    }

    function edit_inspection_t($id, $id_unit, $id_mod)
    {
        $data['title'] = "Technical Analysis 2 - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id_unit, $id_mod);
        $data['select_rating'] = $this->unit_m->select_rating($id);

        if ($_POST == NULL) {
            $data['ta2'] = $this->unit_m->get_ins_t($id);
            $this->load->view('unit/edit_ins_t', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_ins($id);
            redirect('unit/ta2/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_inspection_t($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_ins($id);
        redirect('unit/ta2/' . $id_unit . '/' . $id_mod);
    }

    function export_inspection_t($id, $id_mod)
    {
        $sql = $this->unit_m->select_ins_t($id, $id_mod);

        if (count($sql) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Component Inspection - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:I3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");

            $val = array("No", "Site", "Inspection Date", "Unit No.", "Model", "Component", "Hour Meter", "Rating", "Type");

            $objset->setCellValue("A" . "1", "ARKA Component Inspection");

            for ($a = 0; $a < 9; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff0000')));

            $baris  = 4;
            $i = 1;
            foreach ($sql as $row) {
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $i++);
                $objset->setCellValue("B" . $baris, $row['kode_project']);
                $objset->setCellValue("C" . $baris, $row['ins_date']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['model_no']);
                $objset->setCellValue("F" . $baris, $row['comp_desc']);
                $objset->setCellValue("G" . $baris, $row['ins_hm']);
                if ($row['rating'] == "A") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($green);
                } elseif ($row['rating'] == "B") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($yellow);
                } elseif ($row['rating'] == "C") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($orange);
                } elseif ($row['rating'] == "X") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($red);
                }
                $objset->setCellValue("I" . $baris, $row['type']);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-INS-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/ta2/' . $id . '/' . $id_mod);
        }
    }

    function ed($id, $id_mod)
    {
        $data['title'] = "Electronic Data - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['ed'] = $this->unit_m->select_ins_e($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        $this->load->view('unit/ed', $data);
        $this->load->view('footer');
    }

    function add_inspection_e($id, $id_mod)
    {
        $data['title'] = "Electronic Data - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);

        if ($_POST == NULL) {
            $this->load->view('unit/add_ins_e', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->insert_ins($_POST);
            redirect('unit/ed/' . $id . '/' . $id_mod);
        }
    }

    function edit_inspection_e($id, $id_unit, $id_mod)
    {
        $data['title'] = "Electronic Data - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['mod'] = $this->unit_m->select_mod($id_unit, $id_mod);
        $data['select_rating'] = $this->unit_m->select_rating($id);

        if ($_POST == NULL) {
            $data['ed'] = $this->unit_m->get_ins_e($id);
            $this->load->view('unit/edit_ins_e', $data);
            $this->load->view('footer');
        } else {
            $this->unit_m->edit_ins($id);
            redirect('unit/ed/' . $id_unit . '/' . $id_mod);
        }
    }

    function delete_inspection_e($id, $id_unit, $id_mod)
    {
        $this->unit_m->delete_ins($id);
        redirect('unit/ed/' . $id_unit . '/' . $id_mod);
    }

    function export_inspection_e($id, $id_mod)
    {
        $sql = $this->unit_m->select_ins_e($id, $id_mod);

        if (count($sql) > 0) {
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                ->setTitle("ARKA Component Inspection - " . date("Y-m-d"));  //file title

            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object

            $objget->setTitle('Sheet'); //sheet title

            $objget->getStyle("A3:I3")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            //table header
            $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");

            $val = array("No", "Site", "Inspection Date", "Unit No.", "Model", "Component", "Hour Meter", "Rating", "Type");

            $objset->setCellValue("A" . "1", "ARKA Component Inspection");

            for ($a = 0; $a < 9; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);

                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '3')->applyFromArray($style);
            }

            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ff0000')));

            $baris  = 4;
            $i = 1;
            foreach ($sql as $row) {
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A" . $baris, $i++);
                $objset->setCellValue("B" . $baris, $row['kode_project']);
                $objset->setCellValue("C" . $baris, $row['ins_date']);
                $objset->setCellValue("D" . $baris, $row['unit_no']);
                $objset->setCellValue("E" . $baris, $row['model_no']);
                $objset->setCellValue("F" . $baris, $row['comp_desc']);
                $objset->setCellValue("G" . $baris, $row['ins_hm']);
                if ($row['rating'] == "A") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($green);
                } elseif ($row['rating'] == "B") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($yellow);
                } elseif ($row['rating'] == "C") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($orange);
                } elseif ($row['rating'] == "X") {
                    $objset->setCellValue("H" . $baris, $row['rating'])->getStyle("H" . $baris)->applyFromArray($red);
                }
                $objset->setCellValue("I" . $baris, $row['type']);

                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . $baris)->getNumberFormat()->setFormatCode('0');

                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-INS-" . date("Y-m-d") . ".xls"); //file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('unit/ed/' . $id . '/' . $id_mod);
        }
    }

    function condition($id, $id_mod)
    {
        $data['title'] = "Component Condition - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['sos'] = $this->unit_m->select_4_sos($id, $id_mod);
        $data['fc'] = $this->unit_m->select_4_fc($id, $id_mod);
        $data['mps'] = $this->unit_m->select_4_mps($id, $id_mod);
        $data['vi'] = $this->unit_m->select_4_vi($id, $id_mod);
        $data['ta2'] = $this->unit_m->select_4_ta2($id, $id_mod);
        $data['ed'] = $this->unit_m->select_4_ed($id, $id_mod);
        $data['mod'] = $this->unit_m->select_mod($id, $id_mod);
        $data['r_ins'] = $this->unit_m->getInsByComp($id, $id_mod);
        $data['r_sos'] = $this->unit_m->getSosByComp($id, $id_mod);
        $data['rating_i'] = $this->unit_m->getRatingInsByComp($id, $id_mod);
        $data['rating_s'] = $this->unit_m->getRatingSosByComp($id, $id_mod);

        $this->load->view('unit/condition', $data);
        $this->load->view('footer');
    }
}

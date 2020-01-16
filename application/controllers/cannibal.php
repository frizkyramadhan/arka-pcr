<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cannibal extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
        $this->load->model('cannibal_m');
        $this->load->model('login_m');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        }
    }
    
    function index() {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);
        
        if($pengguna->kode_project == '000H'){
            $data['ba'] = $this->cannibal_m->selectAll();
        }else{
            $data['ba'] = $this->cannibal_m->selectAllByProject();
        }
        
        $this->load->view('cannibal/cannibal', $data);
        $this->load->view('footer');
    }
    
    function add($id_project = 0) {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);
        
        $data['unit_r'] = $this->cannibal_m->getUnit();
        
        if($pengguna->kode_project == '000H'){
            $data['unit_i'] = $this->cannibal_m->getUnit();
        }else{
            $data['unit_i'] = $this->cannibal_m->getUnitByProject();
        }
        
        $this->form_validation->set_rules("data_c[1][id_project]",'Project Code','callback_validate_project');
        $this->form_validation->set_rules("data_c[1][no_ba]",'Doc. Number','required');
        $this->form_validation->set_rules("data_c[1][posting_date]",'Posting Date','required');
        $this->form_validation->set_rules("data_c[1][symptom]",'Symptom','required');
        $this->form_validation->set_rules("data_c[1][failure]",'Failure','required');
        $this->form_validation->set_rules("data_c[1][id_caused]",'Failure Caused','callback_validate_caused');
        $this->form_validation->set_rules("data_c[1][id_status]",'Component Status','callback_validate_status');
        
        $this->form_validation->set_rules("data_d[1][date]",'Date','required');
        $this->form_validation->set_rules("data_d[1][wo_no_kanibal]",'WO Number','required');
        $this->form_validation->set_rules("data_d[1][wo_status_kanibal]",'WO Status','required');
        $this->form_validation->set_rules("data_d[1][id_unit]",'Unit No.','callback_validate_unit');
        $this->form_validation->set_rules("data_d[1][comp_desc]",'Component Description','required');
        $this->form_validation->set_rules("data_d[1][pn]",'Part Number','required');
        $this->form_validation->set_rules("data_d[1][sn]",'Serial Number','required');
        $this->form_validation->set_rules("data_d[1][pos]",'Position','required');
        $this->form_validation->set_rules("data_d[1][hm_comp]",'HM Component','required');
        
        $this->form_validation->set_rules("data_d[2][date]",'Date','required');
        $this->form_validation->set_rules("data_d[2][wo_no_kanibal]",'WO Number','required');
        $this->form_validation->set_rules("data_d[2][wo_status_kanibal]",'WO Status','required');
        $this->form_validation->set_rules("data_d[2][id_unit]",'Unit No.','callback_validate_unit');
        $this->form_validation->set_rules("data_d[2][comp_desc]",'Component Description','required');
        $this->form_validation->set_rules("data_d[2][pn]",'Part Number','required');
        $this->form_validation->set_rules("data_d[2][sn]",'Serial Number','required');
        $this->form_validation->set_rules("data_d[2][pos]",'Position','required');
        $this->form_validation->set_rules("data_d[2][hm_comp]",'HM Component','required');
        
        if($this->form_validation->run()==FALSE){
            $data['ba'] = $this->cannibal_m->getIdBa();
            $data['caused'] = $this->cannibal_m->caused();
            $data['status'] = $this->cannibal_m->status();
            $data['action'] = $this->cannibal_m->action();
            $data['id_project'] = $id_project;
            $data['kode_project'] = $this->cannibal_m->getKodeProject($id_project);
            $data['project'] = $this->cannibal_m->getProject();
            $data['no_ba'] = $this->cannibal_m->generateAutoid($id_project);
            $this->load->view('cannibal/add_cannibal',$data);
            $this->load->view('footer');
        } else {
            foreach($_POST['data_c'] as $c){
                $this->db->insert('ba',$c);
            }
            foreach($_POST['data_d'] as $d){
                $this->db->insert('kanibal',$d);
            }
            redirect('cannibal');
        }
    }
    
    function add_series($id_project = 0) {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);
        
        $data['unit_r'] = $this->cannibal_m->getUnit();
        
        if($pengguna->kode_project == '000H'){
            $data['unit_i'] = $this->cannibal_m->getUnit();
        }else{
            $data['unit_i'] = $this->cannibal_m->getUnitByProject();
        }
        
        $this->form_validation->set_rules("data_c[1][id_project]",'Project Code','callback_validate_project');
        $this->form_validation->set_rules("data_c[1][no_ba]",'Doc. Number','required');
        $this->form_validation->set_rules("data_c[1][posting_date]",'Posting Date','required');
        $this->form_validation->set_rules("data_c[1][symptom]",'Symptom','required');
        $this->form_validation->set_rules("data_c[1][failure]",'Failure','required');
        $this->form_validation->set_rules("data_c[1][id_caused]",'Failure Caused','callback_validate_caused');
        $this->form_validation->set_rules("data_c[1][id_status]",'Component Status','callback_validate_status');
        
        $this->form_validation->set_rules("data_d[1][date]",'Date','required');
        $this->form_validation->set_rules("data_d[1][wo_no_kanibal]",'WO Number','required');
        $this->form_validation->set_rules("data_d[1][wo_status_kanibal]",'WO Status','required');
        $this->form_validation->set_rules("data_d[1][id_unit]",'Unit No.','callback_validate_unit');
        $this->form_validation->set_rules("data_d[1][comp_desc]",'Component Description','required');
        $this->form_validation->set_rules("data_d[1][pn]",'Part Number','required');
        $this->form_validation->set_rules("data_d[1][hm_comp]",'HM Component','required');
        
        $this->form_validation->set_rules("data_d[2][date]",'Date','required');
        $this->form_validation->set_rules("data_d[2][wo_no_kanibal]",'WO Number','required');
        $this->form_validation->set_rules("data_d[2][wo_status_kanibal]",'WO Status','required');
        $this->form_validation->set_rules("data_d[2][id_unit]",'Unit No.','callback_validate_unit');
        $this->form_validation->set_rules("data_d[2][comp_desc]",'Component Description','required');
        $this->form_validation->set_rules("data_d[2][pn]",'Part Number','required');
        $this->form_validation->set_rules("data_d[2][hm_comp]",'HM Component','required');
        
        if($this->form_validation->run()==FALSE){
            $data['ba'] = $this->cannibal_m->getIdBa();
            $data['caused'] = $this->cannibal_m->caused();
            $data['status'] = $this->cannibal_m->status();
            $data['action'] = $this->cannibal_m->action();
            $data['id_project'] = $id_project;
            $data['kode_project'] = $this->cannibal_m->getKodeProject($id_project);
            $data['project'] = $this->cannibal_m->getProject();
            $data['no_ba'] = $this->cannibal_m->generateAutoid($id_project);
            $data['pcr'] = $this->cannibal_m->getReplacement();
            $data['l1'] = $this->cannibal_m->get_l1($id_project);
            $data['l2'] = $this->cannibal_m->get_l2($id_project);
            $data['l3'] = $this->cannibal_m->get_l3($id_project);
            $this->load->view('cannibal/add_cannibal_series',$data);
            $this->load->view('footer');
        } else {
            foreach($_POST['data_c'] as $c){
                $this->db->insert('ba',$c);
            }
            foreach($_POST['data_d'] as $d){
                $this->db->insert('kanibal',$d);
            }
            redirect('cannibal');
        }
    }
    
    function delete($id) {
        $tables = array('ba', 'kanibal');
        $this->db->where('id_ba', $id);
        $this->db->delete($tables);
        redirect('cannibal');
    }
    
    function edit($no_ba = 0,$id_ba = 0) {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        //penentuan dropdown project
        $dbres_proj = $this->db->query('select * from project order by kode_project asc');
        $ddmenu_proj = array();
        foreach ($dbres_proj->result_array() as $tablerow) {
            $ddmenu_proj[$tablerow['id_project']] = $tablerow['kode_project'];
        }
        $data['proj_options'] = $ddmenu_proj;
        
        if($_POST==NULL){
            $data['ba'] = $this->cannibal_m->getDetailBa($no_ba);
            $data['det_r'] = $this->cannibal_m->getDetailRemove($no_ba);
            $data['det_i'] = $this->cannibal_m->getDetailInstall($no_ba);
            $data['caused'] = $this->cannibal_m->caused();
            $data['status'] = $this->cannibal_m->status();
            $data['action'] = $this->cannibal_m->action();
            $data['select_project'] = $this->cannibal_m->select_project($id_ba);
            $this->load->view('cannibal/edit_cannibal', $data);
            $this->load->view('footer');
        } else {
            $this->cannibal_m->edit_ba($id_ba);
            redirect('cannibal/detail/'.$no_ba);
        }
    }
    
    function edit_detail($no_ba, $id_kanibal) {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);
                
        //penentuan dropdown unit        
        if($pengguna->kode_project == '000H'){
            $dbres_unit = $this->db->query('select * from unit join project on unit.id_project = project.id_project order by unit_no asc');
        }else{
            $dbres_unit = $this->db->query("select * from unit join project on unit.id_project = project.id_project where project.kode_project = '$pengguna->kode_project' order by unit_no asc");
        }
        $ddmenu_unit = array();
        foreach ($dbres_unit->result_array() as $tablerow) {
            $ddmenu_unit[$tablerow['id_unit']] = $tablerow['unit_no'];
        }
        $data['unit'] = $ddmenu_unit;
        
        //penentuan dropdown replacement        
        $dbres_rep = $this->db->query("select * from replacement r
                                    left join unit u on r.id_unit = u.id_unit
                                    left join commod m on r.id_mod = m.id_mod
                                    left join comp c on m.id_comp = c.id_comp
                                    left join project p on u.id_project = p.id_project
                                    where wo_no != 0 and wo_status = 'OPEN'");
        $ddmenu_rep = array();
        foreach ($dbres_rep->result_array() as $tablerow) {
            $ddmenu_rep[$tablerow['id_rep']] = $tablerow['wo_no'];
        }
        $data['rep'] = $ddmenu_rep;
        
        $data['det_r'] = $this->cannibal_m->getDetailRemove($no_ba);
        $data['det_i'] = $this->cannibal_m->getDetailInstall($no_ba);
        
        $this->form_validation->set_rules("date",'Date','required');
        $this->form_validation->set_rules("wo_no_kanibal",'WO Number','required');
        $this->form_validation->set_rules("wo_status_kanibal",'WO Status','required');
        $this->form_validation->set_rules("id_unit",'Unit No.','callback_validate_unit');
        $this->form_validation->set_rules("comp_desc",'Component Description','required');
        $this->form_validation->set_rules("pn",'Part Number','required');
        $this->form_validation->set_rules("hm_comp",'HM Component','required');
        
        if($this->form_validation->run()==FALSE){
            $data['det'] = $this->cannibal_m->getDetail($id_kanibal);
            $data['select_unit'] = $this->cannibal_m->select_unit($id_kanibal);
            $data['select_rep'] = $this->cannibal_m->select_rep($id_kanibal);
            $this->load->view('cannibal/edit_detail', $data);
            $this->load->view('footer');
        } else {
            $this->cannibal_m->edit_kanibal($id_kanibal);
            redirect('cannibal/detail/'.$no_ba);
        }
    }
    
    function detail($no_ba) {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $data['ba'] = $this->cannibal_m->getDetailBa($no_ba);
        $data['det_r'] = $this->cannibal_m->getDetailRemove($no_ba);
        $data['det_i'] = $this->cannibal_m->getDetailInstall($no_ba);
        $data['caused'] = $this->cannibal_m->caused();
        $data['status'] = $this->cannibal_m->status();
        $data['action'] = $this->cannibal_m->action();
        $this->load->view('cannibal/detail', $data);
        $this->load->view('footer');
    }
    
    function print_out($no_ba) {
        $data['title'] = "Cannibal List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        
        
        $data['ba'] = $this->cannibal_m->getDetailBa($no_ba);
        $data['det_r'] = $this->cannibal_m->getDetailRemove($no_ba);
        $data['det_i'] = $this->cannibal_m->getDetailInstall($no_ba);
        $data['caused'] = $this->cannibal_m->caused();
        $data['status'] = $this->cannibal_m->status();
        $data['action'] = $this->cannibal_m->action();
        $this->load->view('cannibal/print', $data);
    }
    
    function submit($no_ba){
        $this->db->set('status_ba', 'OPEN');
        $this->db->where('no_ba', $no_ba);
        $this->db->update('ba');
        redirect('cannibal/detail/'.$no_ba);
    }
    
    function cancel($no_ba){
        $this->db->set('status_ba', 'CANCEL');
        $this->db->where('no_ba', $no_ba);
        $this->db->update('ba');
        redirect('cannibal/detail/'.$no_ba);
    }
    
    function close($no_ba){
        $this->db->set('status_ba', 'CLOSE');
        $this->db->where('no_ba', $no_ba);
        $this->db->update('ba');
        redirect('cannibal/detail/'.$no_ba);
    }
    
    function validate_project($value) {
        if($value==""){
            $this->form_validation->set_message('validate_project', 'Please Select Your Project!');
            return false;
        } else {
            return true;
        }
    }
    
    function validate_caused($value) {
        if($value==""){
            $this->form_validation->set_message('validate_caused', 'Please Select Your Failure Caused!');
            return false;
        } else {
            return true;
        }
    }
    
    function validate_status($value) {
        if($value==""){
            $this->form_validation->set_message('validate_status', 'Please Select Your Component Status!');
            return false;
        } else {
            return true;
        }
    }
    
    function validate_unit($value) {
        if($value==""){
            $this->form_validation->set_message('validate_unit', 'Please Select Your Unit Number!');
            return false;
        } else {
            return true;
        }
    }
    
    public function export(){
        $ba = $this->cannibal_m->selectAll();
                 
        if(count($ba)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                    ->setTitle("ARKA Cannibal Report - ".date("Y-m-d"));  //file title
 
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
            $cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N");
             
            $val = array("Site","Date","Document No.","Removed Unit No.","WO No.","Installed Unit No.","WO No","Component Description","Symptom / Problem","Action by Planner","Status","MR No.","PR No.","PO No.");
            
            $objset->setCellValue("A"."1", "ARKA Cannibal Report");
//            $objset->setCellValue("A"."3", "Last Replacement HM");
//            $objset->setCellValue("A"."4", "Last Replacement Date");
//            $objset->setCellValue("A"."5", "Next Replacement Date");
//            $objset->setCellValue("B"."3", $last->hm_unit);
//            $objset->setCellValue("B"."4", $last->rep_date);
//            $objset->setCellValue("B"."5", $next_date);
            
            for ($a=0;$a<14; $a++) 
            {
                $objset->setCellValue($cols[$a].'3', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10); 
                
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'3')->applyFromArray($style);
            }
             
            $baris  = 4;
            foreach ($ba as $row){
                $u_r = $this->db->query("select * from kanibal k left join unit u on k.id_unit = u.id_unit where k.no_ba = ".$row->no_ba." and k.type = 'REMOVE' order by k.id_kanibal desc limit 1")->row();
                $u_i = $this->db->query("select * from kanibal k left join unit u on k.id_unit = u.id_unit where k.no_ba = ".$row->no_ba." and k.type = 'INSTALL' order by k.id_kanibal desc limit 1")->row();
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $row->kode_project);
                $objset->setCellValue("B".$baris, $row->posting_date);
                $objset->setCellValue("C".$baris, $row->no_ba);
                if (empty($u_r)){
                    $objset->setCellValue("D".$baris, "-");
                    $objset->setCellValue("E".$baris, "-");
                }else{
                    $objset->setCellValue("D".$baris, $u_r->unit_no);
                    $objset->setCellValue("E".$baris, $u_r->wo_no_kanibal);
                }
                if (empty($u_i)){
                    $objset->setCellValue("F".$baris, "-");
                    $objset->setCellValue("G".$baris, "-");
                }else{
                    $objset->setCellValue("F".$baris, $u_i->unit_no);
                    $objset->setCellValue("G".$baris, $u_i->wo_no_kanibal);
                }
                $objset->setCellValue("H".$baris, $u_r->comp_desc);
		$objset->setCellValue("I".$baris, $row->symptom);
                $objset->setCellValue("J".$baris, $row->action);
                $objset->setCellValue("K".$baris, $row->status_ba);
                $objset->setCellValue("L".$baris, $row->mr_no);
                $objset->setCellValue("M".$baris, $row->pr_no);
                $objset->setCellValue("N".$baris, $row->po_no);
                                 
                //Set number value
                //$objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("ARKA-Cannibal-".date("Y-m-d").".xls"); //file name
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        }else{
            redirect('cannibal');
        }
    }
}
?>

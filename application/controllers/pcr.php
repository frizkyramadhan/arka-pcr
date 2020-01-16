<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Pcr extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
            $this->load->model('login_m');
            $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        }
    }
    
    function index() {
        $data['title'] = "PCR Summary - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        //penentuan dropdown project
        $dbres_proj = $this->db->query('select * from project order by kode_project asc');
        $ddmenu_proj = array();
        foreach ($dbres_proj->result_array() as $tablerow) {
            $ddmenu_proj[$tablerow['kode_project']] = $tablerow['kode_project'];
        }
        $data['proj_options'] = $ddmenu_proj;
        
        $this->load->view('summary/pcr', $data);
        $this->load->view('footer');
    }
    
    public function export(){
        $bagianWhere = isset($_POST['where'])?$_POST['where']:'';
        
        $sql = $this->db->query("SELECT * 
                FROM replacement r 
                LEFT JOIN unit u ON r.id_unit = u.id_unit
                LEFT JOIN commod cm ON r.id_mod = cm.id_mod
                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                LEFT JOIN project p ON u.id_project = p.id_project
                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                WHERE ".$bagianWhere."
                ORDER BY p.kode_project ASC, m.manufacture ASC, c.comp_desc ASC, r.id_rep DESC")->result_array();
        
//        $data['query'] = $sql;
//        $data['where'] = $bagianWhere;
//        $this->load->view('summary/query', $data);
        //$reps = $this->unit_m->select_reps($id,$id_mod);
        //$avg = $this->unit_m->getAvg($id);
         
        if(count($sql)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                    ->setTitle("ARKA Planned Component Replacement - ".date("Y-m-d"));  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Sheet'); //sheet title
             
            $objget->getStyle("A3:S3")->applyFromArray(
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
            $cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T");
             
            $val = array("Site","Manufacture","Model","Unit No.","Component Description","Policy","Price (IDR)","% Life","Comp Life","Comp Condition","HM Now","WH/Day","Work Order","WO Schedule Date","WO Status","WO Complete Date","Installed Comp Hrs","Last Replacement HM","Last Replacement Date","Next Replacement Date");
            
            $objset->setCellValue("A"."1", "ARKA Planned Component Replacement");
//            $objset->setCellValue("A"."3", "Last Replacement HM");
//            $objset->setCellValue("A"."4", "Last Replacement Date");
//            $objset->setCellValue("A"."5", "Next Replacement Date");
//            $objset->setCellValue("B"."3", $last->hm_unit);
//            $objset->setCellValue("B"."4", $last->rep_date);
//            $objset->setCellValue("B"."5", $next_date);
            
            for ($a=0;$a<20; $a++) 
            {
                $objset->setCellValue($cols[$a].'3', $val[$a]);
                 
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(22);
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'3')->applyFromArray($style);
            }
             
            $baris  = 4;
            foreach ($sql as $row){
                $query = $this->db->query('
                                        select avg (wh_day) as "avg" 
                                        from hm where 
                                        date_hm <= curdate() 
                                        and date_hm >= (DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) 
                                        and id_unit = '.$row['id_unit'].'')->row();
                $hm = $this->db->query('
                                        select * from unit left join hm on hm.id_unit = unit.id_unit where hm.id_unit = '.$row['id_unit'].' order by id_hm desc')->row_array();
                $hm_rep = $hm['hm_unit']; 
                $l_hm = $row['last_hm_rep']; 
                $ich = $row['comp_hour']; 
                $comp_life = ($hm_rep-$l_hm)+$ich;
                $policy = $row['policy'];
                $life = ($comp_life/$policy)*100;
                $wh_day = round($query->avg,1);
                $date = date('Y-m-d');
                if ($wh_day == 0){
                    $forecast = 0;
                } else {
                    $forecast = round(($policy-$comp_life)/$wh_day,0);
                }
                $next = date('Y-m-d', strtotime($date.'+'. $forecast .'days'));
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $row['kode_project']);
                $objset->setCellValue("B".$baris, $row['manufacture']);
                $objset->setCellValue("C".$baris, $row['model_no']);
                $objset->setCellValue("D".$baris, $row['unit_no']);
                $objset->setCellValue("E".$baris, $row['comp_desc']);
                $objset->setCellValue("F".$baris, $row['policy']);
                $objset->setCellValue("G".$baris, $row['price']);
                $objset->setCellValue("H".$baris, round($life,1)."%");
                $objset->setCellValue("I".$baris, $comp_life);
		$objset->setCellValue("J".$baris, $row['comp_cond']);
                if ($row['wo_status'] == "OPEN"){
                    $objset->setCellValue("K".$baris, $hm['hm_unit']);
                }else{
                    $objset->setCellValue("K".$baris, $row['hm_rep']);
                }
                $objset->setCellValue("L".$baris, $wh_day);
                $objset->setCellValue("M".$baris, $row['wo_no']);
                $objset->setCellValue("N".$baris, $row['wo_date']);
                $objset->setCellValue("O".$baris, $row['wo_status']);
                $objset->setCellValue("P".$baris, $row['wo_end_date']);
                $objset->setCellValue("Q".$baris, $row['comp_hour']);
                $objset->setCellValue("R".$baris, $row['last_hm_rep']);
                $objset->setCellValue("S".$baris, $row['last_rep_date']);
                if($row['wo_status'] == "OPEN"){
                    $objset->setCellValue("T".$baris, $next);
                } else {
                    $objset->setCellValue("T".$baris, "");
                }
                                 
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("ARKA-PCR-".date("Y-m-d").".xls"); //file name
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        }else{
            redirect('pcr');
        }
    }
    
    public function export_all(){
//        $bagianWhere = isset($_POST['where'])?$_POST['where']:'';
        
        $sql = $this->db->query("SELECT * 
                FROM replacement r 
                LEFT JOIN unit u ON r.id_unit = u.id_unit
                LEFT JOIN commod cm ON r.id_mod = cm.id_mod
                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                LEFT JOIN project p ON u.id_project = p.id_project
                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                WHERE 1
                ORDER BY p.kode_project ASC, m.manufacture ASC, c.comp_desc ASC, r.id_rep DESC")->result_array();
        
//        $data['query'] = $sql;
//        $data['where'] = $bagianWhere;
//        $this->load->view('summary/query', $data);
        //$reps = $this->unit_m->select_reps($id,$id_mod);
        //$avg = $this->unit_m->getAvg($id);
         
        if(count($sql)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                    ->setTitle("ARKA Planned Component Replacement - ".date("Y-m-d"));  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Sheet'); //sheet title
             
            $objget->getStyle("A3:S3")->applyFromArray(
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
            $cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T");
             
            $val = array("Site","Manufacture","Model","Unit No.","Component Description","Policy","Price (IDR)","% Life","Comp Life","Comp Condition","HM Now","WH/Day","Work Order","WO Schedule Date","WO Status","WO Complete Date","Installed Comp Hrs","Last Replacement HM","Last Replacement Date","Next Replacement Date");
            
            $objset->setCellValue("A"."1", "ARKA Planned Component Replacement");
//            $objset->setCellValue("A"."3", "Last Replacement HM");
//            $objset->setCellValue("A"."4", "Last Replacement Date");
//            $objset->setCellValue("A"."5", "Next Replacement Date");
//            $objset->setCellValue("B"."3", $last->hm_unit);
//            $objset->setCellValue("B"."4", $last->rep_date);
//            $objset->setCellValue("B"."5", $next_date);
            
            for ($a=0;$a<20; $a++) 
            {
                $objset->setCellValue($cols[$a].'3', $val[$a]);
                 
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(22);
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'3')->applyFromArray($style);
            }
             
            $baris  = 4;
            foreach ($sql as $row){
                $query = $this->db->query('
                                        select avg (wh_day) as "avg" 
                                        from hm where 
                                        date_hm <= curdate() 
                                        and date_hm >= (DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) 
                                        and id_unit = '.$row['id_unit'].'')->row();
                
                $hm_rep = $row['hm_rep']; 
                $l_hm = $row['last_hm_rep']; 
                $ich = $row['comp_hour']; 
                $comp_life = ($hm_rep-$l_hm)+$ich;
                $policy = $row['policy'];
                $life = ($comp_life/$policy)*100;
                $wh_day = round($query->avg,1);
                $date = date('Y-m-d');
                if ($wh_day == 0){
                    $forecast = 0;
                } else {
                    $forecast = round(($policy-$comp_life)/$wh_day,0);
                }
                $next = date('Y-m-d', strtotime($date.'+'. $forecast .'days'));
                 
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $row['kode_project']);
                $objset->setCellValue("B".$baris, $row['manufacture']);
                $objset->setCellValue("C".$baris, $row['model_no']);
                $objset->setCellValue("D".$baris, $row['unit_no']);
                $objset->setCellValue("E".$baris, $row['comp_desc']);
                $objset->setCellValue("F".$baris, $row['policy']);
                $objset->setCellValue("G".$baris, $row['price']);
                $objset->setCellValue("H".$baris, round($life,1)."%");
                $objset->setCellValue("I".$baris, $comp_life);
		$objset->setCellValue("J".$baris, $row['comp_cond']);
                $objset->setCellValue("K".$baris, $row['hm_rep']);
                $objset->setCellValue("L".$baris, $wh_day);
                $objset->setCellValue("M".$baris, $row['wo_no']);
                $objset->setCellValue("N".$baris, $row['wo_date']);
                $objset->setCellValue("O".$baris, $row['wo_status']);
                $objset->setCellValue("P".$baris, $row['wo_end_date']);
                $objset->setCellValue("Q".$baris, $row['comp_hour']);
                $objset->setCellValue("R".$baris, $row['last_hm_rep']);
                $objset->setCellValue("S".$baris, $row['last_rep_date']);
                if($row['wo_status'] == "OPEN"){
                    $objset->setCellValue("T".$baris, $next);
                } else {
                    $objset->setCellValue("T".$baris, "");
                }
                                 
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("ARKA-PCR-".date("Y-m-d").".xls"); //file name
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        }else{
            redirect('pcr');
        }
    }
}

?>

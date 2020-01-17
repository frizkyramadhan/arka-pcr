<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Condition extends CI_Controller{
    
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
        $data['title'] = "Component Condition Summary - ARKA Planned Component Replacement";
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
        
        $this->load->view('summary/condition', $data);
        $this->load->view('footer');
    }
    
    public function export(){
        $bagianWhere = isset($_POST['where'])?$_POST['where']:'';
        
        $sql = $this->db->query("SELECT * FROM arka_pcr.condition cd
        LEFT JOIN unit u ON cd.id_unit = u.id_unit
        LEFT JOIN commod cm ON cd.id_mod = cm.id_mod
        LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
        LEFT JOIN project p ON u.id_project = p.id_project
        LEFT JOIN comp c ON cm.id_comp = c.id_comp
        WHERE ".$bagianWhere."
        ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC")->result_array();
                 
        if(count($sql)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                    ->setTitle("ARKA Component Condition - ".date("Y-m-d"));  //file title
 
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
            $cols = array("A","B","C","D","E","F");
             
            $val = array("No","Site","Unit No.","Model","Component","Component Condition");
            
            $objset->setCellValue("A"."1", "ARKA Component Inspection");
            
            for ($a=0;$a<6; $a++) 
            {
                $objset->setCellValue($cols[$a].'3', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
                             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'3')->applyFromArray($style);
            }
            
            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ff0000')));
             
            $baris  = 4;
            $i=1;
            foreach ($sql as $row){
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $i++);
                $objset->setCellValue("B".$baris, $row['kode_project']);
                $objset->setCellValue("C".$baris, $row['unit_no']);
                $objset->setCellValue("D".$baris, $row['model_no']);
                $objset->setCellValue("E".$baris, $row['comp_desc']);
                if($row['condition'] == "NORMAL"){
                    $objset->setCellValue("F".$baris, $row['condition'])->getStyle("F".$baris)->applyFromArray($green);
                }elseif ($row['condition'] == "ATTENTION") {
                    $objset->setCellValue("F".$baris, $row['condition'])->getStyle("F".$baris)->applyFromArray($orange);
                }elseif ($row['condition'] == "CRITICAL") {
                    $objset->setCellValue("F".$baris, $row['condition'])->getStyle("F".$baris)->applyFromArray($red);
                }
                
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("ARKA-COND-".date("Y-m-d").".xls"); //file name
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        }else{
            redirect('condition');
        }
    }
}

?>

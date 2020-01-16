<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Sos extends CI_Controller{
    
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
        $data['title'] = "SOS Summary - ARKA Planned Component Replacement";
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
        
        $this->load->view('summary/sos', $data);
        $this->load->view('footer');
    }
    
    public function export(){
        $bagianWhere = isset($_POST['where'])?$_POST['where']:'';
        
        $sql = $this->db->query("SELECT * 
                FROM sos s 
                LEFT JOIN unit u ON s.id_unit = u.id_unit
                LEFT JOIN commod cm ON s.id_mod = cm.id_mod
                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                LEFT JOIN project p ON u.id_project = p.id_project
                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                WHERE ".$bagianWhere."
                ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, s.id_sos DESC")->result_array();
        
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
                    ->setTitle("ARKA Scheduled Oil Sampling - ".date("Y-m-d"));  //file title
 
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
            $cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU");
             
            $val = array("Lab Name","Lab No","Sample Date","Unit No.","Model","Component","Oil Type","Hrs Oil","Hrs Unit","Evaluation Code","Recommendation","Oil Change","Oil Added",
                "Fe","Cu","Cr","Si","Al","Ni","Sn","Pb","PQ","Soot","Oxid","Nitr","SOX","4um","6um","14um","15um","ISO4406","ISO.14","ISO.6","Ca","Zn","Mo","Bo","P","Na","K","Mg","Visc","TBN","TAN","Gly","Water","Dilution");
            
            $objset->setCellValue("A"."1", "ARKA Scheduled Oil Sampling");
            
            for ($a=0;$a<47; $a++) 
            {
                $objset->setCellValue($cols[$a].'3', $val[$a]);
                 
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
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'3')->applyFromArray($style);
            }
            
            $green = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00ff00')));
            $yellow = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')));
            $orange = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ff9900')));
            $red = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ff0000')));
             
            $baris  = 4;
            foreach ($sql as $row){
                //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $row['lab_name']);
                $objset->setCellValue("B".$baris, $row['lab_no']);
                $objset->setCellValue("C".$baris, $row['sample_date']);
                $objset->setCellValue("D".$baris, $row['unit_no']);
                $objset->setCellValue("E".$baris, $row['model_no']);
                $objset->setCellValue("F".$baris, $row['comp_desc']);
                $objset->setCellValue("G".$baris, $row['oil_type']);
                $objset->setCellValue("H".$baris, $row['h_oil']);
		$objset->setCellValue("I".$baris, $row['h_unit']);
                if($row['eval_code'] == "A" || $row['eval_code'] == "Normal"){
                    $objset->setCellValue("J".$baris, $row['eval_code'])->getStyle("J".$baris)->applyFromArray($green);
                }elseif ($row['eval_code'] == "B" || $row['eval_code'] == "Attention") {
                    $objset->setCellValue("J".$baris, $row['eval_code'])->getStyle("J".$baris)->applyFromArray($yellow);
                }elseif ($row['eval_code'] == "C" || $row['eval_code'] == "D") {
                    $objset->setCellValue("J".$baris, $row['eval_code'])->getStyle("J".$baris)->applyFromArray($orange);
                }elseif ($row['eval_code'] == "X" || $row['eval_code'] == "Urgent") {
                    $objset->setCellValue("J".$baris, $row['eval_code'])->getStyle("J".$baris)->applyFromArray($red);
                }
                $objset->setCellValue("K".$baris, $row['recommendation']);
                $objset->setCellValue("L".$baris, $row['oil_change']);
                $objset->setCellValue("M".$baris, $row['oil_added']);
                $objset->setCellValue("N".$baris, $row['fe']);
                $objset->setCellValue("O".$baris, $row['cu']);
                $objset->setCellValue("P".$baris, $row['cr']);
                $objset->setCellValue("Q".$baris, $row['si']);
                $objset->setCellValue("R".$baris, $row['al']);
                $objset->setCellValue("S".$baris, $row['ni']);
                $objset->setCellValue("T".$baris, $row['sn']);
                $objset->setCellValue("U".$baris, $row['pb']);
                $objset->setCellValue("V".$baris, $row['pq']);
                $objset->setCellValue("W".$baris, $row['soot']);
                $objset->setCellValue("X".$baris, $row['oxid']);
                $objset->setCellValue("Y".$baris, $row['nitr']);
                $objset->setCellValue("Z".$baris, $row['sox']);
                $objset->setCellValue("AA".$baris, $row['4um']);
                $objset->setCellValue("AB".$baris, $row['6um']);
                $objset->setCellValue("AC".$baris, $row['14um']);
                $objset->setCellValue("AD".$baris, $row['15um']);
                $objset->setCellValue("AE".$baris, $row['iso4406']);
                $objset->setCellValue("AF".$baris, $row['iso14']);
                $objset->setCellValue("AG".$baris, $row['iso6']);
                $objset->setCellValue("AH".$baris, $row['ca']);
                $objset->setCellValue("AI".$baris, $row['zn']);
                $objset->setCellValue("AJ".$baris, $row['mo']);
                $objset->setCellValue("AK".$baris, $row['bo']);
                $objset->setCellValue("AL".$baris, $row['p']);
                $objset->setCellValue("AM".$baris, $row['na']);
                $objset->setCellValue("AN".$baris, $row['k']);
                $objset->setCellValue("AO".$baris, $row['mg']);
                $objset->setCellValue("AP".$baris, $row['visc']);
                $objset->setCellValue("AQ".$baris, $row['tbn']);
                $objset->setCellValue("AR".$baris, $row['tan']);
                $objset->setCellValue("AS".$baris, $row['gly']);
                $objset->setCellValue("AT".$baris, $row['water']);
                $objset->setCellValue("AU".$baris, $row['dilution']);
                
                 
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("ARKA-SOS-".date("Y-m-d").".xls"); //file name
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        }else{
            redirect('sos');
        }
    }
}

?>

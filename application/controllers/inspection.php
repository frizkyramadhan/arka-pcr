<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Inspection extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
            $this->load->model('login_m');
            $this->load->model('summary_m');
            $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        }
    }
    
    function index() {
        $data['title'] = "Inspection Summary - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $dbres_proj = $this->db->query('select * from project order by kode_project asc');
        $ddmenu_proj = array();
        foreach ($dbres_proj->result_array() as $tablerow) {
            $ddmenu_proj[$tablerow['kode_project']] = $tablerow['kode_project'];
        }
        $data['proj_options'] = $ddmenu_proj;
        $data['filter_where'] = $this->buildFilterWhere($_POST);
        
        $this->load->view('summary/inspection', $data);
        $this->load->view('footer');
    }

    private function buildFilterWhere($post)
    {
        $bagianWhere = "";
        if (isset($post['siteCat'])) {
            $project = $this->db->escape_like_str($post['kode_project']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "kode_project LIKE '{$project}'";
        }
        if (isset($post['unitCat'])) {
            $unit = $this->db->escape_like_str($post['unit_no']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "unit_no LIKE '%{$unit}%'";
        }
        if (isset($post['compCat'])) {
            $comp = $this->db->escape_like_str($post['comp_desc']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "comp_desc LIKE '%{$comp}%'";
        }
        if (isset($post['ratingCat'])) {
            $rating = $this->db->escape_like_str($post['rating']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "rating LIKE '%{$rating}%'";
        }
        if (isset($post['typeCat'])) {
            $type = $this->db->escape_like_str($post['type']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "type LIKE '%{$type}%'";
        }
        return $bagianWhere === '' ? '1' : $bagianWhere;
    }

    function datatable()
    {
        $p = $this->summary_m->getDtParams();
        $where = $this->summary_m->sanitizeWhere($this->input->get_post('where'));
        $records_total = $this->summary_m->countInspection('1', '');
        $records_filtered = $this->summary_m->countInspection($where, $p['search']);
        $rows = $this->summary_m->getInspectionPage(
            $where, $p['search'], $p['start'], $p['length'], $p['order_col'], $p['order_dir']
        );

        $data = array();
        $no = $p['start'] + 1;
        foreach ($rows as $row) {
            $warna = '#ffffff';
            if ($row->rating == 'A') {
                $warna = '#00ff00';
            } elseif ($row->rating == 'B') {
                $warna = '#ffff00';
            } elseif ($row->rating == 'C') {
                $warna = '#ff9900';
            } elseif ($row->rating == 'X') {
                $warna = '#ff0000';
            }
            $data[] = array(
                'no' => $no++,
                'kode_project' => htmlspecialchars((string) $row->kode_project),
                'ins_date' => htmlspecialchars((string) $row->ins_date),
                'unit_no' => htmlspecialchars((string) $row->unit_no),
                'comp_desc' => htmlspecialchars((string) $row->comp_desc),
                'ins_hm' => htmlspecialchars((string) $row->ins_hm),
                'rating' => '<span style="background:'.$warna.';padding:2px 8px;font-weight:bold;">'.htmlspecialchars((string) $row->rating).'</span>',
                'type' => htmlspecialchars((string) $row->type)
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'draw' => $p['draw'],
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_filtered,
            'data' => $data
        ), JSON_UNESCAPED_UNICODE));
    }
    
    public function export(){
        $bagianWhere = $this->summary_m->sanitizeWhere(isset($_POST['where']) ? $_POST['where'] : '1');
        $sql = $this->summary_m->getInspectionExportRows($bagianWhere);
        
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
                    ->setTitle("ARKA Component Inspection - ".date("Y-m-d"));  //file title
 
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
            $cols = array("A","B","C","D","E","F","G","H","I");
             
            $val = array("No","Site","Inspection Date","Unit No.","Model","Component","Hour Meter","Rating","Type");
            
            $objset->setCellValue("A"."1", "ARKA Component Inspection");
            
            for ($a=0;$a<9; $a++) 
            {
                $objset->setCellValue($cols[$a].'3', $val[$a]);
                 
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
                $objset->setCellValue("C".$baris, $row['ins_date']);
                $objset->setCellValue("D".$baris, $row['unit_no']);
                $objset->setCellValue("E".$baris, $row['model_no']);
                $objset->setCellValue("F".$baris, $row['comp_desc']);
                $objset->setCellValue("G".$baris, $row['ins_hm']);
                if($row['rating'] == "A"){
                    $objset->setCellValue("H".$baris, $row['rating'])->getStyle("H".$baris)->applyFromArray($green);
                }elseif ($row['rating'] == "B") {
                    $objset->setCellValue("H".$baris, $row['rating'])->getStyle("H".$baris)->applyFromArray($yellow);
                }elseif ($row['rating'] == "C") {
                    $objset->setCellValue("H".$baris, $row['rating'])->getStyle("H".$baris)->applyFromArray($orange);
                }elseif ($row['rating'] == "X") {
                    $objset->setCellValue("H".$baris, $row['rating'])->getStyle("H".$baris)->applyFromArray($red);
                }
                $objset->setCellValue("I".$baris, $row['type']);
                
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('A1:A'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export'); //sheet title
 
            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("ARKA-INS-".date("Y-m-d").".xls"); //file name
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
            $objWriter->save('php://output');
        }else{
            redirect('inspection');
        }
    }
}

?>

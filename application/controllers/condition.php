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
            $this->load->model('summary_m');
            $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        }
    }
    
    function index() {
        $data['title'] = "Component Condition Summary - ARKA Planned Component Replacement";
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
        
        $this->load->view('summary/condition', $data);
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
        if (isset($post['modelCat'])) {
            $model = $this->db->escape_like_str($post['model_no']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "model_no LIKE '%{$model}%'";
        }
        if (isset($post['condCat'])) {
            $cond = $this->db->escape_like_str($post['condition']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "cd.condition LIKE '%{$cond}%'";
        }
        return $bagianWhere === '' ? '1' : $bagianWhere;
    }

    function datatable()
    {
        $p = $this->summary_m->getDtParams();
        $where = $this->summary_m->sanitizeWhere($this->input->get_post('where'));
        $records_total = $this->summary_m->countCondition('1', '');
        $records_filtered = $this->summary_m->countCondition($where, $p['search']);
        $rows = $this->summary_m->getConditionPage(
            $where, $p['search'], $p['start'], $p['length'], $p['order_col'], $p['order_dir']
        );

        $data = array();
        $no = $p['start'] + 1;
        foreach ($rows as $row) {
            $warna = '#ffffff';
            if ($row->condition == 'NORMAL') {
                $warna = '#00ff00';
            } elseif ($row->condition == 'ATTENTION') {
                $warna = '#ff9900';
            } elseif ($row->condition == 'CRITICAL') {
                $warna = '#ff0000';
            }
            $data[] = array(
                'no' => $no++,
                'kode_project' => htmlspecialchars((string) $row->kode_project),
                'unit_no' => htmlspecialchars((string) $row->unit_no),
                'model_no' => htmlspecialchars((string) $row->model_no),
                'comp_desc' => htmlspecialchars((string) $row->comp_desc),
                'condition' => '<span style="background:'.$warna.';padding:2px 8px;font-weight:bold;">'.htmlspecialchars((string) $row->condition).'</span>'
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
        $sql = $this->summary_m->getConditionExportRows($bagianWhere);
                 
        if(count($sql)>0){
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("Frizky Ramadhan - IT HO Balikpapan") //creator
                    ->setTitle("ARKA Component Condition - ".date("Y-m-d"));  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Sheet'); //sheet title
             
            $objget->getStyle("A3:F3")->applyFromArray(
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
            
            $objset->setCellValue("A"."1", "ARKA Component Condition");
            
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

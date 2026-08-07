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
            $this->load->model('summary_m');
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
        $data['filter_where'] = $this->buildFilterWhere($_POST);
        
        $this->load->view('summary/pcr', $data);
        $this->load->view('footer');
    }

    private function buildFilterWhere($post)
    {
        $bagianWhere = "";
        if (isset($post['manCat'])) {
            $man = $this->db->escape_like_str($post['manufacture']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "manufacture LIKE '%{$man}%'";
        }
        if (isset($post['siteCat'])) {
            $project = $this->db->escape_like_str($post['kode_project']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "kode_project LIKE '{$project}'";
        }
        if (isset($post['modCat'])) {
            $model = $this->db->escape_like_str($post['model_no']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "model_no LIKE '%{$model}%'";
        }
        if (isset($post['unitCat'])) {
            $unit = $this->db->escape_like_str($post['unit_no']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "unit_no LIKE '%{$unit}%'";
        }
        if (isset($post['compCat'])) {
            $comp = $this->db->escape_like_str($post['comp_desc']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "comp_desc LIKE '%{$comp}%'";
        }
        if (isset($post['polCat'])) {
            $pol = $this->db->escape_like_str($post['policy']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "policy LIKE '%{$pol}%'";
        }
        if (isset($post['priCat'])) {
            $pri = $this->db->escape_like_str($post['price']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "price LIKE '%{$pri}%'";
        }
        if (isset($post['woCat'])) {
            $wo_no = $this->db->escape_like_str($post['wo_no']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "wo_no LIKE '%{$wo_no}%'";
        }
        if (isset($post['staCat'])) {
            $wo_status = $this->db->escape_like_str($post['wo_status']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "wo_status LIKE '%{$wo_status}%'";
        }
        return $bagianWhere === '' ? '1' : $bagianWhere;
    }

    function datatable()
    {
        $p = $this->summary_m->getDtParams();
        $where = $this->summary_m->sanitizeWhere($this->input->get_post('where'));

        $records_total = $this->summary_m->countPcr('1', '');
        $records_filtered = $this->summary_m->countPcr($where, $p['search']);
        $rows = $this->summary_m->getPcrPage(
            $where, $p['search'], $p['start'], $p['length'], $p['order_col'], $p['order_dir']
        );

        $data = array();
        $no = $p['start'] + 1;
        foreach ($rows as $row) {
            $data[] = array(
                'no' => '<a href="'.site_url('unit/replacement/'.$row->id_unit.'/'.$row->id_mod).'" target="_blank"><i class="icon-circle-arrow-right"></i></a>',
                'kode_project' => htmlspecialchars((string) $row->kode_project),
                'manufacture' => htmlspecialchars((string) $row->manufacture),
                'model_no' => htmlspecialchars((string) $row->model_no),
                'unit_no' => htmlspecialchars((string) $row->unit_no),
                'comp_desc' => htmlspecialchars((string) $row->comp_desc),
                'policy' => $row->policy,
                'price' => $row->price,
                'life_percent' => round((float) $row->life_percent_calc, 1) . ' %',
                'comp_life' => round((float) $row->comp_life_calc, 1),
                'comp_cond' => htmlspecialchars((string) $row->comp_cond),
                'hm_now' => $row->hm_now,
                'wh_day' => $row->wh_day,
                'wo_no' => htmlspecialchars((string) $row->wo_no),
                'wo_date' => htmlspecialchars((string) $row->wo_date),
                'wo_status' => htmlspecialchars((string) $row->wo_status),
                'wo_end_date' => htmlspecialchars((string) $row->wo_end_date),
                'comp_hour' => $row->comp_hour,
                'last_hm_rep' => $row->last_hm_rep,
                'last_rep_date' => htmlspecialchars((string) $row->last_rep_date),
                'next_date' => htmlspecialchars((string) $row->next_date),
                'remarks' => htmlspecialchars((string) $row->remarks)
            );
            $no++;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'draw' => $p['draw'],
                'recordsTotal' => $records_total,
                'recordsFiltered' => $records_filtered,
                'data' => $data
            ), JSON_UNESCAPED_UNICODE));
    }
    
    public function export(){
        $bagianWhere = $this->summary_m->sanitizeWhere(isset($_POST['where']) ? $_POST['where'] : '1');
        $sql = $this->summary_m->getPcrExportRows($bagianWhere);
        
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
            $hm_map = $this->summary_m->getLatestHmMap(array_map(function ($r) { return $r['id_unit']; }, $sql));
            foreach ($sql as $row){
                $wh_day = round($this->summary_m->getWhDayAvg($row['id_unit']), 1);
                if ($row['wo_status'] == "OPEN") {
                    $hm_rep = isset($hm_map[(int)$row['id_unit']]) ? $hm_map[(int)$row['id_unit']] : 0;
                } else {
                    $hm_rep = $row['hm_rep'];
                }
                $l_hm = $row['last_hm_rep']; 
                $ich = $row['comp_hour']; 
                $comp_life = ($hm_rep-$l_hm)+$ich;
                $policy = $row['policy'] ? $row['policy'] : 1;
                $life = ($comp_life/$policy)*100;
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
                    $objset->setCellValue("K".$baris, $hm_rep);
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

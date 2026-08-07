<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cannibal_summary extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/process_login');
        } else {
            $this->load->model('login_m');
            $this->load->model('summary_m');
            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        }
    }

    function index() {
        $data['title'] = "Cannibal Summary - ARKA Planned Component Replacement";
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
        $data['status_options'] = array(
            'DRAFT' => 'DRAFT',
            'OPEN' => 'OPEN',
            'CLOSE' => 'CLOSE',
            'CANCEL' => 'CANCEL',
            'REJECTED' => 'REJECTED'
        );
        $data['filter_where'] = $this->buildFilterWhere($_POST);

        $this->load->view('summary/cannibal_summary', $data);
        $this->load->view('footer');
    }

    private function buildFilterWhere($post)
    {
        $bagianWhere = "";
        if (isset($post['siteCat'])) {
            $project = $this->db->escape_like_str($post['kode_project']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "p.kode_project LIKE '{$project}'";
        }
        if (isset($post['dateCat'])) {
            $date = $this->db->escape_like_str($post['posting_date']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "ba.posting_date LIKE '%{$date}%'";
        }
        if (isset($post['docCat'])) {
            $doc = $this->db->escape_like_str($post['no_ba']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "ba.no_ba LIKE '%{$doc}%'";
        }
        if (isset($post['removeUnitCat'])) {
            $unit = $this->db->escape_like_str($post['unit_remove']);
            $ur = $this->summary_m->cannibalUnitRemoveSql();
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "{$ur} LIKE '%{$unit}%'";
        }
        if (isset($post['installUnitCat'])) {
            $unit = $this->db->escape_like_str($post['unit_install']);
            $ui = $this->summary_m->cannibalUnitInstallSql();
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "{$ui} LIKE '%{$unit}%'";
        }
        if (isset($post['pnCat'])) {
            $pn = $this->db->escape_like_str($post['pn']);
            $ps = $this->summary_m->cannibalPnSql();
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "{$ps} LIKE '%{$pn}%'";
        }
        if (isset($post['compCat'])) {
            $comp = $this->db->escape_like_str($post['comp_desc']);
            $cs = $this->summary_m->cannibalCompSql();
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "{$cs} LIKE '%{$comp}%'";
        }
        if (isset($post['statusCat'])) {
            $status = $this->db->escape_like_str($post['status_ba']);
            $bagianWhere .= (empty($bagianWhere) ? '' : ' AND ') . "ba.status_ba LIKE '{$status}'";
        }
        return $bagianWhere === '' ? '1' : $bagianWhere;
    }

    function datatable()
    {
        $p = $this->summary_m->getDtParams();
        $where = $this->summary_m->sanitizeWhere($this->input->get_post('where'));
        $records_total = $this->summary_m->countCannibalSummary('1', '');
        $records_filtered = $this->summary_m->countCannibalSummary($where, $p['search']);
        $rows = $this->summary_m->getCannibalSummaryPage(
            $where, $p['search'], $p['start'], $p['length'], $p['order_col'], $p['order_dir']
        );

        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'no' => '<a href="'.site_url('cannibal/detail/'.$row->no_ba).'" target="_blank"><i class="icon-circle-arrow-right"></i></a>',
                'kode_project' => htmlspecialchars((string) $row->kode_project),
                'posting_date' => htmlspecialchars((string) $row->posting_date),
                'no_ba' => htmlspecialchars((string) $row->no_ba),
                'unit_remove' => $row->unit_remove ? htmlspecialchars((string) $row->unit_remove) : '-',
                'unit_install' => $row->unit_install ? htmlspecialchars((string) $row->unit_install) : '-',
                'pn' => $row->pn ? htmlspecialchars((string) $row->pn) : '-',
                'comp_desc' => $row->comp_desc ? htmlspecialchars((string) $row->comp_desc) : '-',
                'symptom' => htmlspecialchars((string) $row->symptom),
                'action_planner' => htmlspecialchars((string) $row->action),
                'status_ba' => htmlspecialchars((string) $row->status_ba),
                'mr_no' => htmlspecialchars((string) $row->mr_no),
                'pr_no' => htmlspecialchars((string) $row->pr_no),
                'po_no' => htmlspecialchars((string) $row->po_no)
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'draw' => $p['draw'],
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_filtered,
            'data' => $data
        ), JSON_UNESCAPED_UNICODE));
    }

    public function export()
    {
        $bagianWhere = $this->summary_m->sanitizeWhere(isset($_POST['where']) ? $_POST['where'] : '1');
        $sql = $this->summary_m->getCannibalSummaryExportRows($bagianWhere);

        if (count($sql) > 0) {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()
                ->setCreator("Frizky Ramadhan - IT HO Balikpapan")
                ->setTitle("ARKA Cannibal Summary - " . date("Y-m-d"));

            $objset = $objPHPExcel->setActiveSheetIndex(0);
            $objget = $objPHPExcel->getActiveSheet();
            $objget->setTitle('Sheet');

            $objget->getStyle("A3:O3")->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '92d050')
                ),
                'font' => array(
                    'color' => array('rgb' => '000000')
                )
            ));

            $cols = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O");
            $val = array(
                "Site","Date","Document No.","Removed Unit No.","WO No.",
                "Installed Unit No.","WO No","Part Number","Component Description","Symptom / Problem",
                "Action by Planner","Status","MR No.","PR No.","PO No."
            );

            $objset->setCellValue("A1", "ARKA Cannibal Summary");
            for ($a = 0; $a < 15; $a++) {
                $objset->setCellValue($cols[$a] . '3', $val[$a]);
                $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$a])->setWidth(12);
            }
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);

            $baris = 4;
            foreach ($sql as $row) {
                $objset->setCellValue("A" . $baris, $row['kode_project']);
                $objset->setCellValue("B" . $baris, $row['posting_date']);
                $objset->setCellValue("C" . $baris, $row['no_ba']);
                $objset->setCellValue("D" . $baris, $row['unit_remove'] ? $row['unit_remove'] : '-');
                $objset->setCellValue("E" . $baris, $row['wo_remove'] ? $row['wo_remove'] : '-');
                $objset->setCellValue("F" . $baris, $row['unit_install'] ? $row['unit_install'] : '-');
                $objset->setCellValue("G" . $baris, $row['wo_install'] ? $row['wo_install'] : '-');
                $objset->setCellValue("H" . $baris, $row['pn'] ? $row['pn'] : '-');
                $objset->setCellValue("I" . $baris, $row['comp_desc'] ? $row['comp_desc'] : '-');
                $objset->setCellValue("J" . $baris, $row['symptom']);
                $objset->setCellValue("K" . $baris, $row['action']);
                $objset->setCellValue("L" . $baris, $row['status_ba']);
                $objset->setCellValue("M" . $baris, $row['mr_no']);
                $objset->setCellValue("N" . $baris, $row['pr_no']);
                $objset->setCellValue("O" . $baris, $row['po_no']);
                $baris++;
            }

            $objPHPExcel->getActiveSheet()->setTitle('Data Export');
            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("ARKA-Cannibal-Summary-" . date("Y-m-d") . ".xls");

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            redirect('cannibal_summary');
        }
    }
}

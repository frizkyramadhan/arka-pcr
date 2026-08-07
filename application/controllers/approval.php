<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Approval extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
        $this->load->model('approval_m');
        $this->load->model('login_m');
        }
    }

    private function getAppBySign($sign) {
        if($sign == 'L1'){
            return $this->approval_m->getAppL1();
        }elseif ($sign == 'L2'){
            return $this->approval_m->getAppL2();
        }elseif ($sign == 'L3') {
            return $this->approval_m->getAppL3();
        }elseif ($sign == 'LPL') {
            return $this->approval_m->getAppLpl();
        }elseif ($sign == 'LGM') {
            return $this->approval_m->getAppLgm();
        }elseif ($sign == 'LOD') {
            return $this->approval_m->getAppLod();
        }elseif ($sign == 'LPD') {
            return $this->approval_m->getAppLpd();
        }
        return $this->approval_m->getApp();
    }
    
    function index() {
        $data['title'] = "Approval List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        $this->load->view('approval/approval', $data);
        $this->load->view('footer');
    }

    function datatable() {
        $username = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($username);

        $draw = (int) $this->input->get_post('draw');
        $start = max(0, (int) $this->input->get_post('start'));
        $length = (int) $this->input->get_post('length');
        if ($length === 0) {
            $length = 10;
        }
        // DataTables "All" option sends -1
        if ($length < 0) {
            $length = -1;
        }

        $search = '';
        $search_arr = $this->input->get_post('search');
        if (is_array($search_arr) && isset($search_arr['value'])) {
            $search = trim($search_arr['value']);
        }

        $order_col = 0;
        $order_dir = 'desc';
        $order = $this->input->get_post('order');
        if (is_array($order) && isset($order[0]['column'])) {
            $order_col = (int) $order[0]['column'];
            $order_dir = isset($order[0]['dir']) ? $order[0]['dir'] : 'desc';
        }

        $records_total = $this->approval_m->countApprovalList($pengguna, '');
        $records_filtered = ($search === '')
            ? $records_total
            : $this->approval_m->countApprovalList($pengguna, $search);
        $rows = $this->approval_m->getApprovalListPage(
            $pengguna, $search, $start, $length, $order_col, $order_dir
        );

        $data = array();
        $no = $start + 1;
        foreach ($rows as $row) {
            $data[] = array(
                'no' => $no++,
                'no_ba' => '<a href="'.site_url('cannibal/detail/'.$row->no_ba).'" target="_blank">'.htmlspecialchars($row->no_ba).'</a>',
                'unit_remove' => $row->unit_remove ? htmlspecialchars($row->unit_remove) : '-',
                'unit_install' => $row->unit_install ? htmlspecialchars($row->unit_install) : '-',
                'posting_date' => htmlspecialchars($row->posting_date),
                'status_l1' => $this->statusBadge($row->status_l1),
                'status_l2' => $this->statusBadge($row->status_l2),
                'status_l3' => $this->statusBadge($row->status_l3),
                'status_lgm' => $this->statusBadge($row->status_lgm),
                'status_lpl' => $this->statusBadge($row->status_lpl),
                'status_lod' => $this->statusBadge($row->status_lod),
                'status_lpd' => $this->statusBadge($row->status_lpd),
                'action' => '<a href="'.site_url('approval/detail/'.$row->no_ba).'" class="btn btn-mini btn-info">Detail</a>'
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'draw' => $draw,
                'recordsTotal' => $records_total,
                'recordsFiltered' => $records_filtered,
                'data' => $data
            ), JSON_UNESCAPED_UNICODE));
    }

    private function statusBadge($status) {
        $status = (string) $status;
        $class = 'label';
        if ($status === 'APPROVED') {
            $class .= ' label-success';
        } elseif ($status === 'PENDING') {
            $class .= ' label-warning';
        } elseif ($status === 'NOT APPROVED') {
            $class .= ' label-important';
        } else {
            $class .= ' label-info';
        }
        return '<span class="'.$class.'">'.htmlspecialchars($status).'</span>';
    }
    
    function detail($id) {
        $data['title'] = "Approval List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $pengguna = $this->login_m->dataPengguna($username);
        $data['app'] = $this->getAppBySign($pengguna->sign);
        
        $data['ba'] = $this->approval_m->getDetailBa($id);
        $data['det_r'] = $this->approval_m->getDetailRemove($id);
        $data['det_i'] = $this->approval_m->getDetailInstall($id);
        $data['caused'] = $this->approval_m->caused();
        $data['status'] = $this->approval_m->status();
        $data['action'] = $this->approval_m->action();
        $data['l1'] = $this->approval_m->getUserL1($id);
        $data['l2'] = $this->approval_m->getUserL2($id);
        $data['l3'] = $this->approval_m->getUserL3($id);
        $data['lpl'] = $this->approval_m->getUserLpl($id);
        $data['lgm'] = $this->approval_m->getUserLgm($id);
        $data['lod'] = $this->approval_m->getUserLod($id);
        $data['lpd'] = $this->approval_m->getUserLpd($id);
        
        if($_POST==NULL){
            $data['select_optl1'] = $this->approval_m->select_optl1($id);
            $data['select_optl2'] = $this->approval_m->select_optl2($id);
            $data['select_optl3'] = $this->approval_m->select_optl3($id);
            $data['select_optlpl'] = $this->approval_m->select_optlpl($id);
            $data['select_optlgm'] = $this->approval_m->select_optlgm($id);
            $data['select_optlod'] = $this->approval_m->select_optlod($id);
            $data['select_optlpd'] = $this->approval_m->select_optlpd($id);
            $this->load->view('approval/detail', $data);
            $this->load->view('footer');
        } else {
            $this->approval_m->edit_ba($id);
            redirect('approval');
        }
    }
}
?>

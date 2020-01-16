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
    
    function index() {
        $data['title'] = "Approval List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $pengguna = $this->login_m->dataPengguna($username);
        if($pengguna->sign == 'L1'){
            $data['app'] = $this->approval_m->getAppL1();
        }elseif ($pengguna->sign == 'L2'){
            $data['app'] = $this->approval_m->getAppL2();
        }elseif ($pengguna->sign == 'L3') {
            $data['app'] = $this->approval_m->getAppL3();
        }else{
            $data['app'] = $this->approval_m->getApp();
        }
        if ($pengguna->kode_project == '000H'){
            $data['app'] = $this->approval_m->getAllApp();
        }
        
        $this->load->view('approval/approval', $data);
        $this->load->view('footer');
    }
    
    function detail($id) {
        $data['title'] = "Approval List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $pengguna = $this->login_m->dataPengguna($username);
        if($pengguna->sign == 'L1'){
            $data['app'] = $this->approval_m->getAppL1();
        }elseif ($pengguna->sign == 'L2'){
            $data['app'] = $this->approval_m->getAppL2();
        }else {
            $data['app'] = $this->approval_m->getAppL3();
        }
        
        $data['ba'] = $this->approval_m->getDetailBa($id);
        $data['det_r'] = $this->approval_m->getDetailRemove($id);
        $data['det_i'] = $this->approval_m->getDetailInstall($id);
        $data['caused'] = $this->approval_m->caused();
        $data['status'] = $this->approval_m->status();
        $data['action'] = $this->approval_m->action();
        $data['l1'] = $this->approval_m->getUserL1($id);
        $data['l2'] = $this->approval_m->getUserL2($id);
        $data['l3'] = $this->approval_m->getUserL3($id);
        
        if($_POST==NULL){
            $data['select_optl1'] = $this->approval_m->select_optl1($id);
            $data['select_optl2'] = $this->approval_m->select_optl2($id);
            $data['select_optl3'] = $this->approval_m->select_optl3($id);
            $this->load->view('approval/detail', $data);
            $this->load->view('footer');
        } else {
            $this->approval_m->edit_ba($id);
            redirect('approval');
        }
    }
}
?>

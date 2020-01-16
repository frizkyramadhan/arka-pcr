<?php

class User extends CI_Controller{
        
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
        $this->load->model('user_m');
        $this->load->model('login_m');
        }
    }
    
    function index() {
        $data['title'] = "User Access - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
    	
        $data['users'] = $this->user_m->selectAll();
        $this->load->view('user/users', $data);
        $this->load->view('footer');
    }
    
    function add() {
        $data['title'] = "User Access - ARKA Planned Component Replacement";
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
            $this->load->view('user/add_user', $data);
            $this->load->view('footer');
        } else {
            $this->user_m->insert($_POST);
            redirect('user');
        }
    }
    
    function delete($id) {
        $this->user_m->delete($id);
        redirect('user');
    }
    
    function edit($id) {
        $data['title'] = "User Access - ARKA Planned Component Replacement";
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
            $data['users'] = $this->user_m->select($id);
            $data['select_user'] = $this->user_m->select_level($id);
            $data['select_project'] = $this->user_m->select_project($id);
            $data['select_sign'] = $this->user_m->select_sign($id);
            $this->load->view('user/edit_user', $data);
            $this->load->view('footer');
        } else {
            $this->user_m->update($id);
            redirect('user');
        }
        
    }
}

?>

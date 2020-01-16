<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Project extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
        $this->load->model('project_m');
        $this->load->model('login_m');
        }
    }
    
    function index() {
        $data['title'] = "Project List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $data['project'] = $this->project_m->selectAll();
        $this->load->view('project/project', $data);
        $this->load->view('footer');
    }
    
    function add() {
        $data['title'] = "Project List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        if($_POST==NULL){
            $this->load->view('project/add_project');
            $this->load->view('footer');
        } else {
            $this->project_m->insert($_POST);
            redirect('project');
        }
    }
    
    function delete($id) {
        $this->project_m->delete($id);
        redirect('project');
    }
    
    function edit($id) {
        $data['title'] = "Project List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        if($_POST==NULL){
            $data['project'] = $this->project_m->select($id);
//            $data['select_project'] = $this->project_m->select_project($id);
            $this->load->view('project/edit_project', $data);
            $this->load->view('footer');
        } else {
            $this->project_m->update($id);
            redirect('project');
        }
        
    }
    
}
?>

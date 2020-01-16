<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Hm extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
        $this->load->model('hm_m');
        $this->load->model('login_m');
        }
    }
    
    function index() {
        $data['title'] = "Hour Meter List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        //pagination setting
        $config['base_url'] = site_url('hm/index');
        $config['total_rows'] = $this->db->count_all('hm');
        $config['per_page'] = 100;
        $config['uri_segment'] = 3;
        //$choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);
        
        // integrate bootstrap pagination
        $config['cur_tag_open'] = '<b class="btn btn-info">';
        $config['cur_tag_close'] = '</b>';
        $config['anchor_class'] = 'class="btn"';
        
        $this->pagination->initialize($config);		
        
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['hmlist'] = $this->hm_m->get_hm($config["per_page"], $data['page'], NULL);
        
        $this->load->view('hm/hm', $data);
        $this->load->view('footer');
    }
    
    function search()
    {
        $data['title'] = "Hour Meter List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        // get search string
        $search = ($this->input->post("search"))? $this->input->post("search") : "NIL";

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("hm/search/$search");
        $config['total_rows'] = $this->hm_m->get_hm_count($search);
        $config['per_page'] = 100;
        $config["uri_segment"] = 4;
        //$choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['cur_tag_open'] = '<b class="btn btn-info">';
        $config['cur_tag_close'] = '</b>';
        $config['anchor_class'] = 'class="btn"';
        
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        // get books list
        $data['hmlist'] = $this->hm_m->get_hm($config['per_page'], $data['page'], $search);

        //load view
        $this->load->view('hm/hm', $data);
        $this->load->view('footer');
    }
    
    function add() {
        $data['title'] = "Hour Meter List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        //penentuan dropdown unit
        $dbres_unit = $this->db->query('select * from unit order by unit_no asc');
        $ddmenu_unit = array();
        foreach ($dbres_unit->result_array() as $tablerow) {
            $ddmenu_unit[$tablerow['id_unit']] = $tablerow['unit_no'];
        }
        $data['unit_options'] = $ddmenu_unit;
        
        if($_POST==NULL){
            $this->load->view('hm/add_hm',$data);
            $this->load->view('footer');
        } else {
            $this->hm_m->insert($_POST);
            redirect('hm');
        }
    }
    
    function delete($id) {
        $this->hm_m->delete($id);
        redirect('hm');
    }
    
    function edit($id) {
        $data['title'] = "Hour Meter List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        //penentuan dropdown unit
        $dbres_unit = $this->db->query('select * from unit order by unit_no asc');
        $ddmenu_unit = array();
        foreach ($dbres_unit->result_array() as $tablerow) {
            $ddmenu_unit[$tablerow['id_unit']] = $tablerow['unit_no'];
        }
        $data['unit_options'] = $ddmenu_unit;
        
        if($_POST==NULL){
            $data['hm'] = $this->hm_m->select($id);
            $data['select_unit'] = $this->hm_m->select_unit($id);
            $this->load->view('hm/edit_hm', $data);
            $this->load->view('footer');
        } else {
            $this->hm_m->update($id);
            redirect('hm');
        }   
    }
}
?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Component extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('isLogin') == FALSE){
            redirect('login/process_login');
        }else {
        $this->load->model('comp_m');
        $this->load->model('login_m');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        }
    }
    
    function index() {
        $data['title'] = "Component List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        $data['component'] = $this->comp_m->selectAll();
        $this->load->view('comp/comp', $data);
        $this->load->view('footer');
    }
    
    function add() {
        $data['title'] = "Component List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        if($_POST==NULL){
            $this->load->view('comp/add_comp',$data);
            $this->load->view('footer');
        } else {
            $this->comp_m->insert($_POST);
            redirect('component');
        }
    }
    
    function delete($id) {
        $this->comp_m->delete($id);
        redirect('component');
    }
    
    function edit($id) {
        $data['title'] = "Component List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        if($_POST==NULL){
            $data['component'] = $this->comp_m->select($id);
            $data['select_type'] = $this->comp_m->select_type($id);
            $this->load->view('comp/edit_comp', $data);
            $this->load->view('footer');
        } else {
            $this->comp_m->update($id);
            redirect('component');
        }
    }
    
    function import() {
        $data['title'] = "Component List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);
        
        if ($this->input->post('save')) {
            $fileName = $_FILES['import']['name'];
 
            $config['upload_path'] = './assets/file/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size']        = 10000;
 
            $this->load->library('upload');
            $this->upload->initialize($config);
 
            if(! $this->upload->do_upload('import') )
                $this->upload->display_errors();
 
            $media = $this->upload->data('import');
            $inputFileName = './assets/file/'.$media['file_name'];
 
            //  Read your Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
 
            //  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                //  Insert row data array into your database of choice here
                $data = array(
                            "id_comp"=> $rowData[0][1],
                            "comp_desc"=> $rowData[0][2],
                            "comp_type"=> $rowData[0][3]
                        );
 
                $this->db->insert("comp",$data);
            }
                        echo "Import Success";
              }
        
        $this->load->view('comp/import', $data);
        $this->load->view('footer');        
    }
    
}
?>

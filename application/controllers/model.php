<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/process_login');
        } else {
            $this->load->model('model_m');
            $this->load->model('login_m');
            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        }
    }

    function index()
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['model'] = $this->model_m->selectAll();
        $this->load->view('model/model', $data);
        $this->load->view('footer');
    }

    function add()
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        //penentuan dropdown component
        $dbres_comp = $this->db->query('select * from comp where status = "Active" order by comp_desc asc');
        $ddmenu_comp = array();
        foreach ($dbres_comp->result_array() as $tablerow) {
            $ddmenu_comp[$tablerow['id_comp']] = $tablerow['comp_desc'];
        }
        $data['comp_options'] = $ddmenu_comp;

        if ($_POST == NULL) {
            $this->load->view('model/add_model', $data);
            $this->load->view('footer');
        } else {
            $this->model_m->insert($_POST);
            redirect('model');
        }
    }

    function add_comp($model)
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        //penentuan dropdown component
        $dbres_comp = $this->db->query('select * from comp where status = "Active" order by comp_desc asc');
        $ddmenu_comp = array();
        foreach ($dbres_comp->result_array() as $tablerow) {
            $ddmenu_comp[$tablerow['id_comp']] = $tablerow['comp_desc'];
        }
        $data['comp_options'] = $ddmenu_comp;

        if ($_POST == NULL) {
            $data['model'] = $this->model_m->select($model);
            $this->load->view('model/add_comp', $data);
            $this->load->view('footer');
        } else {
            $this->model_m->insert_mod($_POST);
            redirect('model/detail/' . $model);
        }
    }

    function delete($id)
    {
        $this->model_m->delete($id);
        redirect('model');
    }

    function del_comp($id_model, $id)
    {
        $this->model_m->del_mod($id);
        redirect('model/detail/' . $id_model);
    }

    function edit($id)
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        //penentuan dropdown component
        $dbres_comp = $this->db->query('select * from comp where status = "Active" order by comp_desc asc');
        $ddmenu_comp = array();
        foreach ($dbres_comp->result_array() as $tablerow) {
            $ddmenu_comp[$tablerow['id_comp']] = $tablerow['comp_desc'];
        }
        $data['comp_options'] = $ddmenu_comp;

        if ($_POST == NULL) {
            $data['model'] = $this->model_m->select($id);
            $data['select_comp'] = $this->model_m->select_desc($id);
            $this->load->view('model/edit_model', $data);
            $this->load->view('footer');
        } else {
            $this->model_m->update($id);
            redirect('model/detail/' . $id);
        }
    }

    function edit_comp($id_model, $id)
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        //penentuan dropdown component
        $dbres_comp = $this->db->query('select * from comp where status = "Active" order by comp_desc asc');
        $ddmenu_comp = array();
        foreach ($dbres_comp->result_array() as $tablerow) {
            $ddmenu_comp[$tablerow['id_comp']] = $tablerow['comp_desc'];
        }
        $data['comp_options'] = $ddmenu_comp;

        if ($_POST == NULL) {
            $data['model'] = $this->model_m->select_model($id);
            $data['select_comp'] = $this->model_m->select_comp($id);
            $this->load->view('model/edit_comp', $data);
            $this->load->view('footer');
        } else {
            $this->model_m->update_mod($id);
            redirect('model/detail/' . $id_model);
        }
    }

    function detail($id)
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
        $username = $this->session->userdata('username');
        $data['pengguna'] = $this->login_m->dataPengguna($username);
        $this->load->view('header', $data);
        $this->load->view('navbar', $data);

        $data['model'] = $this->model_m->select($id);
        $data['comp'] = $this->model_m->select_mod($id);
        $this->load->view('model/detail', $data);
        $this->load->view('footer');
    }

    function import()
    {
        $data['title'] = "Model List - ARKA Planned Component Replacement";
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

            if (!$this->upload->do_upload('import'))
                $this->upload->display_errors();

            $media = $this->upload->data('import');
            $inputFileName = './assets/file/' . $media['file_name'];

            //  Read your Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE
                );
                //  Insert row data array into your database of choice here
                $data = array(
                    "id_model" => $rowData[0][1],
                    "model_no" => $rowData[0][2],
                    "manufacture" => $rowData[0][3],
                    "description" => $rowData[0][4]
                );

                $this->db->insert("model", $data);
            }
            echo "Import Success";
        }

        $this->load->view('model/import', $data);
        $this->load->view('footer');
    }
}

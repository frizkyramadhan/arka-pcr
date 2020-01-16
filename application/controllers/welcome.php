<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
        function __construct() {
            parent::__construct();
            if($this->session->userdata('isLogin') == FALSE){
                redirect('login/process_login');
            }else {
            $this->load->model('user_m');
            $this->load->model('unit_m');
            $this->load->model('cannibal_m');
            $this->load->model('login_m');
            $this->load->model('approval_m');
            }
        }

	public function index(){
            $data['title'] = "ARKA Planned Component Replacement";
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
            $data['ba'] = $this->cannibal_m->selectPMNotApproved();
            $data['crit'] = $this->unit_m->getCritical();
            $this->load->view('welcome',$data);
            $this->load->view('footer');
    }

    public function cannibal(){
            $data['title'] = "ARKA Planned Component Replacement";
            $username = $this->session->userdata('username');
            $data['pengguna'] = $this->login_m->dataPengguna($username);
            $this->load->view('header', $data);
            $this->load->view('navbar', $data);

            $data['ba'] = $this->cannibal_m->selectPMNotApproved()->result();
            $this->load->view('summary/cannibal',$data);
            $this->load->view('footer');
    }

//    public function oil_sampling(){
//            $data['title'] = "ARKA Planned Component Replacement";
//            $username = $this->session->userdata('username');
//            $data['pengguna'] = $this->login_m->dataPengguna($username);
//            $this->load->view('header', $data);
//            $this->load->view('navbar', $data);
//
//            $this->load->view('summary/oil_sampling',$data);
//            $this->load->view('footer');
//    }

    public function replacement(){
            $data['title'] = "ARKA Planned Component Replacement";
            $username = $this->session->userdata('username');
            $data['pengguna'] = $this->login_m->dataPengguna($username);
            $this->load->view('header', $data);
            $this->load->view('navbar', $data);
            $this->load->view('summary/replacement',$data);
            $this->load->view('footer');
    }
    
//    public function magnetic(){
//            $data['title'] = "ARKA Planned Component Replacement";
//            $username = $this->session->userdata('username');
//            $data['pengguna'] = $this->login_m->dataPengguna($username);
//            $this->load->view('header', $data);
//            $this->load->view('navbar', $data);
//
//            $this->load->view('summary/magnetic',$data);
//            $this->load->view('footer');
//    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
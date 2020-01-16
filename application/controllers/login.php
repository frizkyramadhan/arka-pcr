<?php

class Login extends CI_Controller {
   
    function __construct() {
        parent::__construct();
        $this->load->model('login_m');
        
    }
    
    public function index() {
        $session = $this->session->userdata('isLogin');
        if($session == FALSE){
            redirect('login/process_login');
        }  else {
            redirect('welcome');
        }
    }
    
     public function process_login()
  {
    $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
    $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    
      if($this->form_validation->run()==FALSE)
      {
        $this->load->view('login');
      }else
      {
       $username = $this->input->post('username');
       $password = $this->input->post('password');
       
       $cek = $this->login_m->ambilPengguna($username, $password);
        
        if($cek <> 0)
        {
          $nama = $this->login_m->dataPengguna($username);
          //$kode_project = $this->login_m->dataPengguna($nik);
          
          $this->session->set_userdata('isLogin', TRUE);
          $this->session->set_userdata('username',$username);
          $this->session->set_userdata('level', $level);
          $this->session->set_userdata('kode_project', $kode_project);
          
          redirect('welcome');
        }else
        {
         echo " <script>
		            alert('Gagal Login: Cek Username dan Password Anda!');
		            history.go(-1);
		          </script>";        
        }
      }  
  }
  
  function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
  
  
  public function logout()
  {
      $this->session->set_userdata(array(
          'username' => ''
      ));
      $this->session->sess_destroy();
        redirect('login');
  }

}
?>

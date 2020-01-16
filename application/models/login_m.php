<?php

class Login_m extends CI_Model{
    
    function __construct() {
        $this->load->model('user_m');
    }
    
    var $table = 'user';

    public function ambilPengguna($username, $password) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function dataPengguna($username)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->from('project');
        $this->db->where('user.id_project = project.id_project');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->row();
    }
    
}

?>

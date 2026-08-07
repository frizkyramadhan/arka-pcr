<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reuse CodeIgniter's mysqli connection (from application/config/database.php).
 * Avoids hardcoded credentials scattered across views.
 *
 * @return mysqli|resource
 */
if (!function_exists('mysqli_conn')) {
    function mysqli_conn()
    {
        static $conn = null;
        if ($conn !== null) {
            return $conn;
        }

        $CI =& get_instance();
        if (!isset($CI->db) || empty($CI->db->conn_id)) {
            $CI->load->database();
        }

        $conn = $CI->db->conn_id;
        return $conn;
    }
}

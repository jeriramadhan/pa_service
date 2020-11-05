<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class user_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_datapekerjaan() {
        $punyacara = $this->load->database('punya_acara', TRUE);
        $punyacara->select('ID_PEKERJAAN,DESC1,DESC2');
        $qryget = $punyacara->get('data_pekerjaan');
        $punyacara->close();
        return $qryget;
    }
    
    function get_user($username,$password) {
        $punyacara = $this->load->database('punya_acara', TRUE);
        $punyacara->select('username,nama');
        $pass = md5($password);
        $punyacara->where('username', $username);
        $punyacara->where('password', $pass);
        $qryget = $punyacara->get('user');
        $punyacara->close();
        return $qryget;
    }
    function cek_user($username) {
        $punyacara = $this->load->database('punya_acara', TRUE);
        $punyacara->select('username');
        $punyacara->where('username', $username);
        $qryget = $punyacara->get('user');
        $punyacara->close();
        return $qryget;
    }

    function create_user($username,$nama,$password) {
        $punyacara = $this->load->database('punya_acara', TRUE);
        $pass = md5($password);
        $data = array(
        'username' => $username,
        'nama' => $nama,
        'password' => $pass
        );
        $punyacara->insert('user',$data);
        $punyacara->close();
        return $qryget;
    }


}
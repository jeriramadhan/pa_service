<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    function inquiryPekerjaan($request) {
    $result               = new stdClass;
    $result->responseCode = "";
    $result->responseDesc = "";

    $user = '';
    $CI   = & get_instance();
    $CI->load->model('activity_model');
    $CI->load->model('user_model');
    $datapost = json_decode($request);
    try {
        $user = $datapost->user;
        if ($CI->libs_bearer->cekToken() == false) {
            throw new Exception("Access Forbidden");
        }

        if (!isset($datapost->user)) {
            throw new Exception("Parameter user tidak valid");
        }
        
        $resdata = $CI->user_model->get_datapekerjaan();
        if (!$resdata || $resdata->num_rows() == 0) {
            throw new Exception("Data tidak ditemukan.");
        }
        $result->responseCode = '00';
        $result->responseDesc = 'Inquiry Sukses.';
        $result->responseData = $resdata->result();

    } catch (Exception $e) {
    	$result->responseCode = '99';
    	$result->responseDesc = $e->getMessage()." Ln.".$e->getLine();
    }

    $CI->activity_model->insert_activity((isset($datapost->requestMethod) ? $CI->security->xss_clean(trim($datapost->requestMethod)) : '') . ' RESPONSE ', json_encode(array("responseCode" => $result->responseCode, "responseDesc" => $result->responseDesc)));
    return $result;
}

function login($request) {
    $result               = new stdClass;
    $result->responseCode = "";
    $result->responseDesc = "";

    $user = '';
    $CI   = & get_instance();
    $CI->load->model('activity_model');
    $CI->load->model('user_model');
    $datapost = json_decode($request);
    try {
        $user = $datapost->user;
        if ($CI->libs_bearer->cekToken() == false) {
            throw new Exception("Access Forbidden");
        }
        if (!isset($datapost->user)) {
            throw new Exception("Parameter user tidak valid");
        }

        $password = $datapost->password;
        if (!isset($datapost->user)) {
            throw new Exception("Parameter password tidak valid");
        }

        $resdata = $CI->user_model->get_user($user,$password);
        if (!$resdata || $resdata->num_rows() == 0) {
            throw new Exception("Akun tidak ditemukan.");
        }
        $result->responseCode = '00';
        $result->responseDesc = 'Inquiry Sukses.';
        $result->responseData = $resdata->result();
    } catch (Exception $e) {
    	$result->responseCode = '99';
    	$result->responseDesc = $e->getMessage()." Ln.".$e->getLine();
    }

    $CI->activity_model->insert_activity((isset($datapost->requestMethod) ? $CI->security->xss_clean(trim($datapost->requestMethod)) : '') . ' RESPONSE ', json_encode(array("responseCode" => $result->responseCode, "responseDesc" => $result->responseDesc)));
    return $result;
}

function register($request) {
    $result               = new stdClass;
    $result->responseCode = "";
    $result->responseDesc = "";

    $user = '';
    $CI   = & get_instance();
    $CI->load->model('activity_model');
    $CI->load->model('user_model');
    $datapost = json_decode($request);
    try {
        $user = $datapost->user;
        if ($CI->libs_bearer->cekToken() == false) {
            throw new Exception("Access Forbidden");
        }
        if (!isset($datapost->user)) {
            throw new Exception("Parameter user tidak valid");
        }
        $nama = $datapost->nama;
        if (!isset($datapost->nama)) {
            throw new Exception("Parameter nama tidak valid");
        }
        $password = $datapost->password;
        if (!isset($datapost->user)) {
            throw new Exception("Parameter password tidak valid");
        }
        $cekuser = $CI->user_model->cek_user($user);
        if($cekuser->num_rows() != 0){
            throw new Exception("Username sudah digunakan");
        }
        $resdata = $CI->user_model->create_user($user,$nama,$password);
        if (!$resdata) {
            throw new Exception("Data tidak berhasil disimpan.");
        }
        $result->responseCode = '00';
        $result->responseDesc = 'Registrasi Sukses.';
    } catch (Exception $e) {
    	$result->responseCode = '99';
    	$result->responseDesc = $e->getMessage()." Ln.".$e->getLine();
    }

    $CI->activity_model->insert_activity((isset($datapost->requestMethod) ? $CI->security->xss_clean(trim($datapost->requestMethod)) : '') . ' RESPONSE ', json_encode(array("responseCode" => $result->responseCode, "responseDesc" => $result->responseDesc)));
    return $result;
}
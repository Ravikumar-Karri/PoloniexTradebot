<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index() {
        if ($this->session->userdata('username')) {
            $data['page_content'] = $this->load->view('home_master', NULL, TRUE);
            $data['page_title'] = "Home";
            $data['jquery'] = "";
            $this->load->view('main', $data);
        } else {
            redirect("/");
        }
    }

    public function ssp_clinic_physician() {
        if ($this->session->userdata('username')) {
            $this->load->model("manage_physician_model");
            $response = $this->manage_physician_model->ssp_clinic_physician_model();
            echo $response;
        } else {
            echo false;
        }
    }

    public function add_physician() {
        if ($this->session->userdata('username')) {
            $this->load->model("manage_physician_model");
            $response = $this->manage_physician_model->add_physician_model();
        } else {
            $response = "Sesion Expired";
        }
        echo json_encode($response);
    }
}

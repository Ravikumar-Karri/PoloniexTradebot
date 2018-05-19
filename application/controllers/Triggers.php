<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Triggers extends CI_Controller {

    public function index() {
        if ($this->session->userdata('username')) {
            $data['page_content'] = $this->load->view('triggers_master', NULL, TRUE);
            $data['page_title'] = "Sell Triggers";
            $data['jquery'] = $this->load->view('scripts/triggers_script', NULL, TRUE);
            $this->load->view('main', $data);
        } else {
            redirect("/");
        }
    }

    public function sell_triggers() {
        if ($this->session->userdata('username')) {
            $this->load->model("triggers_model");
            $response = $this->triggers_model->sell_triggers_model();
        } else {
            $response = "Sesion Expired";
        }
        echo json_encode($response);
    }

    public function get_dash_info() {
        if ($this->session->userdata('username')) {
            $this->load->model("triggers_model");
            $response = $this->triggers_model->get_dash_info_model();
        } else {
            $response = "Sesion Expired";
        }
        echo json_encode($response);
    }
    
    

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trade_limits extends CI_Controller {

    public function index() {
        if ($this->session->userdata('username')) {
            $data['page_content'] = $this->load->view('trade_limits_master', NULL, TRUE);
            $data['page_title'] = "Trade Limits";
            $data['jquery'] = $this->load->view('scripts/trade_limits_script', NULL, TRUE);
            $this->load->view('main', $data);
        } else {
            redirect("/");
        }
    }

    public function update_trade_limits() {
        if ($this->session->userdata('username')) {
            $this->load->model("trade_limits_model");
            $response = $this->trade_limits_model->update_trade_limits_model();
        } else {
            $response = "Sesion Expired";
        }
        echo json_encode($response);
    }

    public function get_dash_info() {
        if ($this->session->userdata('username')) {
            $this->load->model("trade_limits_model");
            $response = $this->trade_limits_model->get_dash_info_model();
        } else {
            $response = "Sesion Expired";
        }
        echo json_encode($response);
    }

}

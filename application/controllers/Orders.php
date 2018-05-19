<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function index() {
        if ($this->session->userdata('username')) {
            $data['page_content'] = $this->load->view('orders_master', NULL, TRUE);
            $data['page_title'] = "Orders";
            $data['jquery'] = $this->load->view('scripts/orders_script', NULL, TRUE);
            $this->load->view('main', $data);
        } else {
            redirect("/");
        }
    }


    public function ssp_buy_orders() {
        if ($this->session->userdata('username')) {
            $this->load->model("orders_model");
            $response = $this->orders_model->ssp_buy_orders_model();
            echo $response;
        } else {
            echo false;
        }
    }
    public function ssp_sell_orders() {
        if ($this->session->userdata('username')) {
            $this->load->model("orders_model");
            $response = $this->orders_model->ssp_sell_orders_model();
            echo $response;
        } else {
            echo false;
        }
    }

    public function fetch_open_orders(){
      if($this->session->userdata('username')){
        $this->load->model('orders_model');
        $response = $this->orders_model->fetch_open_orders_model();
        echo $response;
      } else {
        echo false;
      }
    }

    public function fetch_open_positions(){
      if($this->session->userdata('username')){
        $this->load->model('orders_model');
        $response = $this->orders_model->fetch_open_positions_model();
        echo $response;
      } else {
        echo false;
      }
    }

}

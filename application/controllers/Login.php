<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function verify_login() {
        $this->load->model("login_model");
        $response = $this->login_model->verify_login_model();
        echo json_encode($response);
    }

    public function logout() {
        if (!$this->session->userdata('username')) {
            log_message("debug", $this->session->userdata("username") . " logged out." .
                    " id = " . $this->session->userdata("user_id"));
        }
        $this->session->sess_destroy();
        redirect("/");
    }

}

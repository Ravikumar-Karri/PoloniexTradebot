<?php

class Login_model extends CI_Model {

    public function verify_login_model() {
        $this->form_validation->set_rules('user', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run()) {
            $data = $this->input->post();

            $this->db->select("id, uname, pass");
            $this->db->from("login_info");
            $this->db->where(
                    array(
                        "uname" => $data["user"],
                        "active" => 1
                    )
            );
            $result = $this->db->get()->result();
            log_message("error", "mail res = " . json_encode($result));
            if ($result) {
                $password = $result[0]->pass;
                if (password_verify($data["pass"], $password)) {
                    log_message("error", "password don't match");
                    $id = intval($result[0]->id);

                    $this->session->set_userdata("username", $data["user"]);
                    $this->session->set_userdata("user_id", $id);

                    log_message("error", "user " . $id . "," . $data["user"] . " logged in");
                    return true;
                } else {
                    return "Username or Password is incorrect";
                }
            } else {
                return "Username or Password is incorrect";
            }
        } else {
            return validation_errors();
        }
    }

}

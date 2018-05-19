<?php

if (!defined('BASEPATH'))
    exit("Access denied!");

class Triggers_model extends CI_Model {

    public function sell_triggers_model() {
        $this->form_validation->set_rules('profit_target', 'Profit Target', 'required|numeric');
        $this->form_validation->set_rules('stop_loss', 'Stop Loss', 'required|numeric');
        $this->form_validation->set_rules('tsl_arm', 'TSL Arm', 'required|numeric');
        $this->form_validation->set_rules('tsl', 'TSL', 'required|numeric');

        if ($this->form_validation->run()) {
            $data = $this->input->post();

            $new_data = array(
                "profit_target" => $data["profit_target"],
                "stop_loss" => $data["stop_loss"],
                "tsl_arm" => $data["tsl_arm"],
                "tsl" => $data["tsl"]
            );

            $this->db->where(array(
                "user_id" => $this->session->userdata("user_id"),
                "active" => 1
            ));

            $this->db->update("poloniex_sell_triggers", $new_data);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return "Sell Trigger is unchanged";
            }
        } else {
            return validation_errors();
        }
    }

    public function get_dash_info_model() {
        $this->db->select("profit_target, stop_loss, tsl_arm, tsl");
        $this->db->from("poloniex_sell_triggers");
        $this->db->where(array(
            "user_id" => $this->session->userdata("user_id"),
            "active" => 1
        ));
        $result = $this->db->get()->result();

        if ($result) {
            return $result[0];
        } else {
            return "No Result Found";
        }
    }

}

<?php

if (!defined('BASEPATH'))
    exit("Access denied!");

class Trade_limits_model extends CI_Model {

    public function get_dash_info_model() {
        $this->db->select("trade_limit, max_amount, min_amount");
        $this->db->from("poloniex_trade_limits");
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

    public function update_trade_limits_model() {
        $this->form_validation->set_rules('trade_limit', 'Total allowable trading amount', 'required|numeric');
        $this->form_validation->set_rules('max_amount', 'Maximum Amount', 'required|numeric');
        $this->form_validation->set_rules('min_amount', 'Minimum Amount', 'required|numeric');

        if ($this->form_validation->run()) {
            $data = $this->input->post();
            
            $new_data = array(
                "trade_limit" => $data["trade_limit"],
                "max_amount" => $data["max_amount"],
                "min_amount" => $data["min_amount"]
            );

            $this->db->where(array(
                "user_id" => $this->session->userdata("user_id"),
                "active" => 1
            ));

            $this->db->update("poloniex_trade_limits", $new_data);
            
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return "Trade limits are unchanged.";
            }
        } else {
            return validation_errors();
        }
    }

}

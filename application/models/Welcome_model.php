<?php if(!defined('BASEPATH')) exit("Access Denied!");
class Welcome_model extends CI_model{

   public function buy_coin_model(){
      $this->form_validation->set_rules('fromcoin','From Coin','required');
      $this->form_validation->set_rules('tocoin','To Coin','required');
      $this->form_validation->set_rules('coinrate','Coin Rate','required');
      $this->form_validation->set_rules('amount','Amount','required');
      if($this->form_validation->run()){
        $data = $this->input->post();
    		$pair = $data['fromcoin']."_".$data['tocoin'];
    		$rate = $data['coinrate'];
    		$amount = $data['amount'];
    		$result = $this->poloniexapi->buy($pair,$rate,$amount);
    		print_r($result);
      } else{
        echo validation_errors();
      }
   }

   public function sell_coin_model(){
      $this->form_validation->set_rules('fromcoin','From Coin','required');
      $this->form_validation->set_rules('tocoin','To Coin','required');
      $this->form_validation->set_rules('coinrate','Coin Rate','required');
      $this->form_validation->set_rules('amount','Amount','required');
      if($this->form_validation->run()){
        $data = $this->input->post();
    		$pair = $data['fromcoin']."_".$data['tocoin'];
    		$rate = $data['coinrate'];
    		$amount = $data['amount'];
    		$result = $this->poloniexapi->sell($pair,$rate,$amount);
    		print_r($result);
      } else{
        echo validation_errors();
      }
   }

   public function checkvolume_model(){
     $result = $this->poloniexapi->get_24_volume();
     print_r($result);
   }

   public function checkbalance_model(){
     $result = $this->poloniexapi->get_balances();
     print_r($result);
   }

   public function checkcompletebalance_model(){
     $result = $this->poloniexapi->get_complete_balances();
     print_r($result);
   }

   public function checkdepositeadd_model(){
     $result = $this->poloniexapi->get_address();
     print_r($result);
   }

   public function checkwidrawalhistory_model(){
     $start = time() - (7 * 24 * 60 * 60);
     $end = time();
     $result = $this->poloniexapi->check_widrawal_deposite_history($start,$end);
     print_r($result);
   }

   public function checkopenorders_model(){
     $result = $this->poloniexapi->get_open_orders('BTC_XRP');
     print_r($result);
   }

   public function checkfeeinfo_model(){
     $result = $this->poloniexapi->get_feeinfo();
     print_r($result);
   }

   public function checkaccountbalance_model(){
     $result = $this->poloniexapi->availble_account_balance();
     print_r($result);
   }

}

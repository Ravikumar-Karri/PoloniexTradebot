<?php
class Sales_bot extends CI_Controller {
     public function index(){
       set_time_limit(60);
        $buyorders = $this->db->get_where('poloniex_buy_orders',array('active'=>'1'));
        if($buyorders->num_rows() > 0){
        $buyorders = $buyorders->result_array();
        $selltriggers = $this->db->get_where('poloniex_sell_triggers',array('active'=>'1'));
        $selltriggers = $selltriggers->row_array();
        $count = 0;
       while($count < 10){
        $this->benchmark->mark("execution_start");
        $currentprices = $this->poloniexapi->get_ticker();
        $currentprices = json_decode(json_encode($currentprices),true);
        foreach ($buyorders as $index => $buyorder) {
          $currentprice = $currentprices[$buyorder['currencypair']];
          $change = $this->percent_change($buyorder['rate'],$currentprice);
          $sell_result = $this->sell_coin($buyorder,$selltriggers,$change,$currentprice);
          if($sell_result == 'success'){
            unset($buyorders[$index]);
          }
        }
        $this->benchmark->mark("execution_end");
        log_message('error',"Sales Bot Total Execution time==> ".$this->benchmark->elapsed_time("execution_start","execution_end"));
        $count++;
        sleep(5);
      }
    }
   }

     private function percent_change($buyprice, $currentprice){
       return ($currentprice['last']-$buyprice) / $buyprice * 100;
     }

     private function sell_coin($buyorder,$selltriggers,$change,$currentprice){
       $pair = $buyorder['currencypair'];
       $rate = $currentprice['last'];
       if($change >= $selltriggers['profit_target']){
         $amount = $buyorder['balance'];
         $result = $this->poloniexapi->sell($pair,$rate,$amount);
         $this->notify_user($pair,$rate,$amount,$result);
         log_message('error','Sell order values ==> Pair==> '.$pair.' Rate==>'.$rate.' Amount==>'.$amount);
         file_put_contents('./assets/selllogs.txt', print_r($result, true),FILE_APPEND);
         $data = array();
         if(!empty($result['resultingTrades'])){
           foreach ($result['resultingTrades'] as $tradedata) {
             $data[] = array('ordernumber'=>$result['orderNumber'],
                             'currencypair'=>$pair,
                             'amount'=>$tradedata['amount'],
                             'date'=>$tradedata['date'],
                             'rate'=>$tradedata['rate'],
                             'total'=>$tradedata['total'],
                             'tradeid'=>$tradedata['tradeID'],
                             'buy_order_id'=>$buyorder['id']
                           );
           }
           $this->db->insert_batch('poloniex_sell_orders',$data);
           log_message('error','Sell order insert Query==>'.$this->db->last_query());
         }
         $this->db->update('poloniex_buy_orders',array('active'=>'2'),array('id'=>$buyorder['id']));
         $this->db->update('poloniex_tsl_orders',array('active'=>'2'),array('buy_order_id'=>$buyorder['id']));
         return 'success';
       } else if ($change <= $selltriggers['stop_loss']){
         $amount = $buyorder['balance'];
         $result = $this->poloniexapi->sell($pair,$rate,$amount);
         $this->notify_user($pair,$rate,$amount,$result);
         log_message('error','Sell order values ==> Pair==> '.$pair.' Rate==>'.$rate.' Amount==>'.$amount);
         file_put_contents('./assets/selllogs.txt', print_r($result, true),FILE_APPEND);
         $data = array();
         if(!empty($result['resultingTrades'])){
           foreach ($result['resultingTrades'] as $tradedata) {
             $data[] = array('ordernumber'=>$result['orderNumber'],
                             'currencypair'=>$pair,
                             'amount'=>$tradedata['amount'],
                             'date'=>$tradedata['date'],
                             'rate'=>$tradedata['rate'],
                             'total'=>$tradedata['total'],
                             'tradeid'=>$tradedata['tradeID'],
                             'buy_order_id'=>$buyorder['id']
                           );
           }
           $this->db->insert_batch('poloniex_sell_orders',$data);
           log_message('error','Insert Query==>'.$this->db->last_query());
         }
         $this->db->update('poloniex_buy_orders',array('active'=>'2'),array('id'=>$buyorder['id']));
         return 'success';
       } else if ($change >= $selltriggers['tsl_arm']){
         $sellorder = array('currencypair'=>$pair,'rate'=>$rate,'amount'=>$buyorder['amount'],'balance'=>$buyorder['balance'],'buy_order_id'=>$buyorder['id']);
         $this->db->insert('poloniex_tsl_orders',$sellorder);
         $this->db->update('poloniex_buy_orders',array('active'=>'2'),array('id'=>$buyorder['id']));
         return 'success';
       }
       return true;
     }


     public function tsl_orders(){
       set_time_limit(60);
       $count = 0;
       while($count < 10){
       $this->benchmark->mark("execution_start");
         $currentprices = $this->poloniexapi->get_ticker();
         $currentprices = json_decode(json_encode($currentprices),true);
         $sellorders = $this->db->get_where('poloniex_tsl_orders',array('active'=>'1'));
         if($sellorders->num_rows() > 0){
           $sellorders = $sellorders->result_array();
           foreach ($sellorders as $sellorder) {
             $currentprice = $currentprices[$sellorder['currencypair']]['last'];
             $trailingloss = $this->percent_change($sellorder['rate'],$currentprice);
             if($trailingloss >= $selltriggers['tsl']) {
               $amount = $sellorder['balance'];
               $result = $this->poloniexapi->sell($sellorder['currencypair'],$currentprice,$amount);
               $this->notify_user($sellorder['currencypair'],$currentprice,$amount,$result);
               log_message('error','Sell order values ==> Pair==> '.$pair.' Rate==>'.$rate.' Amount==>'.$amount);
               file_put_contents('./assets/selllogs.txt', print_r($result, true),FILE_APPEND);
               $data = array();
               if(!empty($result['resultingTrades'])){
                 foreach ($result['resultingTrades'] as $tradedata) {
                   $data[] = array('ordernumber'=>$result['orderNumber'],
                                   'currencypair'=>$pair,
                                   'amount'=>$tradedata['amount'],
                                   'date'=>$tradedata['date'],
                                   'rate'=>$tradedata['rate'],
                                   'total'=>$tradedata['total'],
                                   'tradeid'=>$tradedata['tradeID'],
                                   'buy_order_id'=>$sellorder['buy_order_id']
                                 );
                 }
                 $this->db->insert_batch('poloniex_sell_orders',$data);
                 log_message('error','Insert Query==>'.$this->db->last_query());
               }
               $this->db->update('poloniex_tsl_orders',array('active'=>'2'),array('id'=>$sellorder['id']));
             }
           }
         }
       $this->benchmark->mark("execution_end");
       log_message('error',"TSL Orders Total Execution time==> ".$this->benchmark->elapsed_time("execution_start","execution_end"));
       $count++;
       sleep(5);
      }
     }

     private function notify_user($coin,$rate,$amount,$result_on_exchange){
       $message = "Bot Trigger Sell Order: Coin=> ".$coin." Rate=> ".$rate." Amount of Coin=> ".$amount." Result on exchange ".json_encode($result_on_exchange);
       $to = "bharatsewani1993@gmail.com";
       $subject = "Bot Sold a coin";
       $content = $message;
       $secret_key = "Nr2DRf6nv3wa7C8KHBHfH3ZsRw4ts585SSgXkedv";

       $response = [
           'key' => $secret_key,
           'to' => $to,
           'subject' => $subject,
           'content' => $content
       ];

       log_message("error", "Array response = " . json_encode($response));

       $ch = curl_init("https://users.zirki.ai/developers/mail_manager/PUaNkENTuewL8Kymek3LRLArysYcJ5Xy32L3JCxG");
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
       curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       $output = curl_exec($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       if(curl_error($ch)){
           curl_close($ch);
           return curl_strerror(curl_errno($ch));
       }
       else{
           log_message("error","No error");
           curl_close($ch);
           return true;
       }
     }
}

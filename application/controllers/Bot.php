<?php
class Bot extends CI_Controller{
    public function index(){
       set_time_limit(60);
    //  ini_set('memory_limit','-1');
      $count = 0;
      while($count < 10){
      $this->benchmark->mark("execution_start");
      $apikey='yourmininghamesterapikey';
      $uri='https://www.mininghamster.com/api/v2/'.$apikey;
      $sign=hash_hmac('sha512',$uri,$apikey);
      $ch = curl_init($uri);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      $execResult = curl_exec($ch);
    //  $execResult = '[{"market":"BTC-STEEM","lastprice":"0.00020649","signalmode":"RISE","exchange":"poloniex","basevolume":21.6216181,"time":"2018-03-19 18:55:00"}]';
      $signal = json_decode($execResult,true);
      if($signal[0]['exchange']=='poloniex'){
      log_message('error','Last Signal ==> '.json_encode($execResult));
          $datetime2 = new DateTime($signal[0]['time']);
          $now = new DateTime('now');
          $diff = $now->getTimestamp() - $datetime2->getTimestamp();
          if($diff <= 5 && $signal[0]['signalmode']=="RISE"){
            $this->check_lastbuy();
            $pair =   str_replace("-","_",$signal[0]['market']);
            $amountrow = $this->db->get_where('poloniex_trade_limits',array('active'=>'1'));
            if($amountrow->num_rows() > 0){
                $amountrow = $amountrow->row_array();
            } else {
              $amountrow = $this->db->get_where('poloniex_trade_limits',array('active'=>'1','id'=>'1'));
              $amountrow = $amountrow->row_array();
            }
            $balance = $this->poloniexapi->get_balances();
        //    echo "Btc balance==>".$balance['BTC'];
          //  $balance['BTC'] = 1;
            $amount = ($balance['BTC'] / 100) * $amountrow['min_amount'];
            log_message('error','Current BTC Balance in poloniex==> '.$balance['BTC']);
        //    echo "Amount before function =>".$amount;
            //$amount = $this->btc_to_amount($amount);
            $amount = $amount / $signal[0]['lastprice'];
            log_message('error','Buy Amount ==> '.$amount);
            if(($amount * $signal[0]['lastprice']) < 0.0001){
              $amount = 0.00012/$signal[0]['lastprice'];
              log_message('error','rare amount situation');
            }
      //      echo "Pair==>".$pair;
      //      echo "Signal Price==>".$signal[0]['lastprice'];
      //      echo "Amount ==>".$amount;
            $result =  $this->poloniexapi->buy($pair,$signal[0]['lastprice'],$amount);
            $balances = $this->poloniexapi->get_balances();
            $this->notify_user($pair,$signal[0]['lastprice'],$amount,$result);
            log_message('error','Buy order values ==> Pair==> '.$pair.' Signal==>'.$signal[0]['lastprice'].' Amount==>'.$amount);
            file_put_contents('./assets/buylogs.txt', print_r($result, true),FILE_APPEND);
            $data = array();
            if(!empty($result['resultingTrades'])){
              foreach ($result['resultingTrades'] as $tradedata) {
                $data[] = array('ordernumber'=>$result['orderNumber'],
                                'currencypair'=>$pair,
                                'amount'=>$tradedata['amount'],
                                'balance'=>$balances[str_replace("BTC_","",$pair)],
                                'date'=>$tradedata['date'],
                                'rate'=>$tradedata['rate'],
                                'total'=>$tradedata['total'],
                                'tradeid'=>$tradedata['tradeID']
                              );
              }
              $this->db->insert_batch('poloniex_buy_orders',$data);
              log_message('error','Insert Query==>'.$this->db->last_query());
            } else {
              $result = $this->poloniexapi->get_open_orders($pair);
              file_put_contents('./assets/openorderlog.txt', print_r($result, true),FILE_APPEND);
              if(!empty($result)){
                foreach ($result as $tradedata) {
                  $data[] = array('ordernumber'=>$tradedata['orderNumber'],
                                  'currencypair'=>$pair,
                                  'amount'=>$tradedata['amount'],
                                  'date'=>$tradedata['date'],
                                  'rate'=>$tradedata['rate'],
                                  'total'=>$tradedata['total']
                              //    'tradeid'=>$tradedata['tradeID']
                                );
                }
                $this->db->insert_batch('poloniex_buy_orders',$data);
                log_message('error','Insert Query==>'.$this->db->last_query());
              }
            }
          }
       }
       $this->benchmark->mark("execution_end");
       log_message('error',"Buy Bot Total Execution time==> ".$this->benchmark->elapsed_time("execution_start","execution_end"));
       $count++;
       sleep(5);
     }
    }

    private function btc_to_amount($btcvalue){
      $currentprices = $this->poloniexapi->get_ticker();
      $currentprices = json_decode(json_encode($currentprices),true);
      $currentprice = $currentprices['USDT_BTC']['last'];
      return $btcvalue * $currentprice;
    }

    private function check_lastbuy(){
       $this->db->order_by('id','desc');
       $this->db->limit(1);
       $this->db->select('date');
       $lastbuyrow = $this->db->get_where('poloniex_buy_orders',array('active'=>'1'));
       if($lastbuyrow->num_rows() > 0){
         $datetime2 = new DateTime($lastbuyrow->row()->date);
         $now = new DateTime('now');
         $diff = $now->getTimestamp() - $datetime2->getTimestamp();
         if($diff > 5){
           return true;
         } else {
           log_message('error','Order placed less then 2 seconds ago. The current difference time is'.$diff);
           exit();
         }
       } else {
         return true;
       }
    }

    private function notify_user($coin,$rate,$amount,$result_on_exchange){
      //By Default AWS Server is not configured to send emails.
      //I used my third party server to send emails
      //you can create your own logic to get emails or notification to your server.

      $message = "Bot Trigger Buy Order: Coin=> ".$coin." Rate=> ".$rate." Amount of Coin=> ".$amount." Result on exchange ".json_encode($result_on_exchange);
      $to = "bharatsewani1993@gmail.com";
      $subject = "Bot Purchased a coin";
      $content = $message;
      $secret_key = "";

      $response = [
          'key' => $secret_key,
          'to' => $to,
          'subject' => $subject,
          'content' => $content
      ];

      log_message("error", "Array response = " . json_encode($response));

      $ch = curl_init("myurl");
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
    //  return "Mail Sending Failed";
    //  return true;
    }
}

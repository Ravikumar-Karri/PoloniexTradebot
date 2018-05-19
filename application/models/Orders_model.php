<?php

if (!defined('BASEPATH'))
    exit("Access denied!");

class Orders_model extends CI_Model {

    public function ssp_buy_orders_model() {
        $table = "poloniex_buy_orders";
        $primaryKey = "id";
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'ordernumber', 'dt' => 1),
            array('db' => 'currencypair', 'dt' => 2),
            array('db' => 'amount', 'dt' => 3),
            array('db' => 'date', 'dt' => 4),
            array('db' => 'rate', 'dt' => 5),
            array('db' => 'total', 'dt' => 6),
            array('db' => 'tradeid', 'dt' => 7)
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $where = "active = 1";
        require('assets/ssp.class.php');
        return json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where));
    }

   public function ssp_sell_orders_model() {
        $table = "poloniex_sell_orders";
        $primaryKey = "id";
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'ordernumber', 'dt' => 1),
            array('db' => 'currencypair', 'dt' => 2),
            array('db' => 'amount', 'dt' => 3),
            array('db' => 'date', 'dt' => 4),
            array('db' => 'rate', 'dt' => 5),
            array('db' => 'total', 'dt' => 6),
            array('db' => 'tradeid', 'dt' => 7)
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );
        $where = "active = 1";
        require('assets/ssp.class.php');
        return json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where));
    }

    public function fetch_open_positions_model(){
       //get current buy price on exchange
       $currentprices = $this->poloniexapi->get_ticker();
       $currentprices = json_decode(json_encode($currentprices),true);

       $this->db->select('currencypair,amount,rate,total,date');
       $sellorders = $this->db->get_where('poloniex_sell_orders',array('active'=>'1'));
       $sellorders = $sellorders->result_array();
       $sr = 1;
       $psellorders = array();
       foreach ($sellorders as $sellorder) {
         $sellorder['exchange'] = 'Poloniex';
         $datetime1 = new DateTime($sellorder['date']);
         $datetime2 = new DateTime(date("Y-m-d H:i:s"));
         $interval = $datetime1->diff($datetime2);
         $age = null;
         if($interval->y == 0 && $interval->m == 0 && $interval->d == 0) {
           $age = $interval->format('%h Hours');
         }
         else if($interval->y == 0 && $interval->m == 0) {
           $age = $interval->format('%a Days');
         }
         else if($interval->y !=0 || $interval->m > 0) {
           $age = (intval($interval->format('%m')) + (intval($interval->format('%y'))*12)) . ' Months';
         }
         else {
           $age = "Error";
         }
         $sellorder['date'] = $age;
         $sellorder['result'] = $this->calculate_sellresult($sellorder['amount'],$currentprices[$sellorder['currencypair']['last']],$sellorder['total']);
         $sellorder['currencypair'] = substr($sellorder['currencypair'], strpos($sellorder['currencypair'], "_")+1);
         $psellorders[] = $sellorder;
       }
        $size = sizeof($psellorders);
        $result = '{"draw": 1,"recordsTotal": '.$size.',"recordsFiltered": '.$size.',"data": [';
        foreach ($psellorders as $order){
          $result .= "[";
          $result .= '"'."0".'",';
          $result .= '"'."Poloniex".'",';
          $result .= '"'.$order['currencypair'].'",';
          $result .= '"'.$order['amount'].'",';
          $result .= '"'.$order['rate'].'",';
          $result .=  '"'.$order['total'].'",';
          $result .=  '"'.$age.'",';
          $result .=  '"'.'test'.'"';
          $result .= "],";
        }
        if($size > 0) {
         $result = substr($result, 0, strlen($result)-1);
        }
        $result .= "]}";
        return $result;
    }

    public function fetch_open_orders_model(){
       $orders = $this->poloniexapi->get_open_orders('ALL');

    //  $orders = '{"BTC_XRP":[],"BTC_KC":[{"orderNumber":"120466","type":"sell","rate":"0.025","amount":"100","total":"2.5","date":"2018-03-30 23:05:19"},{"orderNumber":"120467","type":"sell","rate":"0.04","amount":"100","total":"4","date":"2015-03-27 23:05:19"}],"BTC_LIT":[{"orderNumber":"120464","type":"sell","rate":"0.025","amount":"100","total":"2.5","date":"2018-03-27 23:05:19"},{"orderNumber":"120467","type":"sell","rate":"0.04","amount":"100","total":"4","date":"2012-03-27 23:05:19"}]}';

       $orders = json_encode($orders);
       $data = json_decode($orders);
       $orders = array();

       foreach ($data as $key => $btc) {
          $btc_name = substr($key, strpos($key, "_")+1);
        foreach ($btc as $key => $record) {
          $record->btc_name = $btc_name;
          array_push($orders, $record);
        }
       }

       $size = sizeof($orders);
       $result = '{"draw": 1,"recordsTotal": '.$size.',"recordsFiltered": '.$size.',"data": [';


       foreach ($orders as $order => $value){
        $datetime1 = new DateTime($value->date);
        $datetime2 = new DateTime(date("Y-m-d H:i:s"));
        $interval = $datetime1->diff($datetime2);
        $age = null;
        if($interval->y == 0 && $interval->m == 0 && $interval->d == 0) {
          $age = $interval->format('%h Hours');
        }
        else if($interval->y == 0 && $interval->m == 0) {
          $age = $interval->format('%a Days');
        }
        else if($interval->y !=0 || $interval->m > 0) {
          $age = (intval($interval->format('%m')) + (intval($interval->format('%y'))*12)) . ' Months';
        }
        else {
          $age = "Error";
        }

        // {"y":0,"m":0,"d":2,"h":0,"i":58,"s":4,"f":0,"weekday":0,"weekday_behavior":0,"first_last_day_of":0,"invert":0,"days":2,"special_type":0,"special_amount":0,"have_weekday_relative":0,"have_special_relative":0}

         $result .= "[";
         $result .= '"'."0".'",';
         $result .= '"'."Poloniex".'",';
         $result .= '"'.$value->btc_name.'",';
         $result .= '"'."BTC".'",';
         $result .= '"'.$value->type.'",';
         $result .= '"'.$value->amount.'",';
         $result .= '"'.$value->rate.'",';
         $result .=  '"'.$value->total.'",';
         $result .=  '"'.$age.'"';
         $result .= "],";

      }
       if($size > 0) {
        $result = substr($result, 0, strlen($result)-1);
       }
       $result .= "]}";

        return $result;
    }

    private function calculate_sellresult($amount,$currentprice,$selltotal){
       $cost = $amount * $currentprice;
       $fees = (0.15/100) *  $cost;
       $current_buy_price = $cost + $fees;
       $sellfees = (0.25/100) * $selltotal;
       $current_sell_total = $selltotal + $sellfees;
       $percentChange = (1 - $current_sell_total / $current_buy_price) * 100;
       return $percentChange;
    }


}

<?php

namespace App\Controllers;

use lib\PaymentSys\LiqPay;
use System\Error;

require_once __DIR__ . '/../../lib/Parser/ParseCoinCurs.php';
require_once __DIR__ . '/../../lib/PaymentSys/LiqPay.php';


class PaymantController extends AccountController
{
    private $public_key = 'i57415901071';
    private $private_key = 'rHFavUhwhixwd4J0HrgSRsV37PtOo5CJn92plEpg';

    public function __construct()
    {
        parent::__construct();
    }

    public function createAction()
    {
        if(!empty($_POST)){
            $sum = $_POST['usd'];
            $id = hash('md5', time());
//            $this->connection->beginTransaction();
            $this->connection
                ->query("INSERT INTO deposit (id, user_id, usd) 
                                   VALUE ('$id', '$this->user_id', $sum)
            ");
            echo  json_encode(array('invoice_id' => $id));
        }
    }

    public function payAction($id)
    {
        $data = $this->invoice($id);

        if($data['status'] == 1) exit('Заказ оплачен');
        if($data['status'] == null) exit('Заказ не существует');

        $array =array(
            'action'         => 'pay',
            'amount'         => $data['amount'],
            'currency'       => 'UAH',
            'description'    => 'Оплата контракта ID_'.$id,
            'order_id'       => $id,
            'version'        => '3',
            'server_url'     => 'http://unionhash.com/callback',
            'result_url'     => 'http://unionhash.com/status/'.$id,
        );

        $test = new LiqPay($this->public_key, $this->private_key);
        $html = $test->cnb_form($array);

        echo $this->twig->render('page/pay', array(
            'form' => $html,
            'id' => $id,
            'description' => '',
            'amount' => $data['amount'],

        ));
    }

    private function invoice($id)
    {
        $invoice = $this->connection
            ->query("SELECT * FROM deposit WHERE id = '$id'")
            ->fetchAll(\PDO::FETCH_ASSOC);
        if($invoice != null){
            $response =  array('amount' => $invoice[0]['usd'], 'status' => $invoice[0]['status']);
        }else{
            $response =  array('error');
        }

        return $response;

    }

    private function check_signature($data, $liqpay_signature)
    {
        $server_signature = base64_encode( sha1( $this->private_key . $data . $this->private_key, 1 ) );
        return ($liqpay_signature === $server_signature) ? true : false;
    }

    public function callbackAction()
    {
        if(!$_POST) Error::E404();

        $data = $_POST['data'];
        $liqpay_signature = $_POST['signature'];

        if ($this->check_signature($data, $liqpay_signature)){

            $liqpay_obj = json_decode(base64_decode($data));
            $order_id = $liqpay_obj->order_id;
            $status = $liqpay_obj->status;
            $amount = $liqpay_obj->amount;
            switch ($status){
                case "wait_accept" :
                    $status = 1;
                    break;
                case "success" :
                    $status = 1;
                    break;
                default:
                    $status = 0;
            }
            $this->connection->beginTransaction();
            $this->connection->query("UPDATE deposit SET status = $status WHERE id = '$order_id'");
            $this->connection->query("UPDATE account SET usd_balance = $amount WHERE user_id = (SELECT user_id FROM deposit WHERE id = '$order_id')");
            $this->connection->commit();
        }
    }

    public function statusAction($id)
    {
        $id = htmlspecialchars($id);
        $comment = '';

        $data = $this->connection
                ->query("SELECT * FROM deposit WHERE id = '$id'")
                ->fetchAll(\PDO::FETCH_ASSOC);

        if(!$data){
            $comment = array(
                'id' => $id,
                'description' => 'Платежа нет в базе, обратитесь в поддержку');
        }else{
            $comment = array(
                'id' => $id,
                'amount' => 'Сумма платежа: '.$data[0]['usd'].' USD',
                'description' => 'Статус платежа '.$data[0]['status'],

            );
        }

        echo $this->twig->render('page/status', $comment);
    }
}


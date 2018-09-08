<?php
/**
 * Created by PhpStorm.
 * User: user 1
 * Date: 30.11.2017
 * Time: 0:12
 */

namespace lib;


use Blockchain\Blockchain;

class Bitcoin
{
    private $b;
    public function __construct()
    {
        $this->b = new Blockchain();
    }

    public function send()
    {
        $this->b->setServiceUrl('https://www.blockchain.com');
        $this->b->Wallet->credentials('6e63b92e-70e6-4ea7-9cef-2a2652c088df', 'greg21lion25');
        $this->b->Wallet->getBalance();
    }
}
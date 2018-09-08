<?php

namespace App\Controllers;

use App\Configuration\Conf;
use Lib\Package;
use System\DB;
use System\TwigView;
use System\Lang;
use System\Verification;

abstract class BaseController
{
    protected $twig;
    protected $options;
    protected $connection;
    protected $lang;
    protected $config;
    protected $verification;

    public function __construct()
    {
        $this->twig  = new TwigView();
        $this->connection = DB::connection();
        $this->options = new Package();
        $this->lang = new Lang(__DIR__.'/../../var/lang/'.$this->options->param['ln'].'.php');
        $this->twig->addG('options', $this->options->param);
        $this->twig->addG('lang', $this->lang->get_list());
        $this->config = Conf::init();
        $this->verification = new Verification();
    }

}
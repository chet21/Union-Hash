<?php

namespace App\Controllers;


use lib\User;
use System\Error;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if($this->verification->check()){
            header('Location: /dashboard');
        }
    }

    public function indexAction()
    {
        echo $this->twig->render('page/index', array('ln' => $this->lang->get_list()));
    }

    public function enterAction()
    {
        if(empty($_POST)) Error::E404();

        $new = new User();
        echo $new->authorization($_POST['login'], $_POST['password'], $this->config->get('sold'));
    }

    public function regAction()
    {
        if($_POST['check'])
        {
            $new = new User();
            echo ($new->check($_POST['check']));
        }elseif(($_POST['login']) && $_POST['password'])
        {
            $new = new User();
            $new->registration($_POST['login'], $_POST['password'], $this->config->get('sold'));
        }elseif (!$_POST || empty($_POST))
        {
            Error::E404();
        }
    }

    public function outAction()
    {
        if(empty($_POST)) Error::E404();

        if ($_POST('stat') == 1){
            session_unset();
        }
    }
}

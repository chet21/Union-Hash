<?php

namespace System;


class TwigView
{
    private $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem(__DIR__.'/../app/views');
        $this->twig = new \Twig_Environment($this->loader);
    }

    public function render($template, $params)
    {
        return $this->twig->render($template.'.html.twig', $params);
    }

    public function addG($name, $val)
    {
        $this->twig->addGlobal($name, $val);
    }

}
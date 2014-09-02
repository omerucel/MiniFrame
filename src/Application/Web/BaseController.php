<?php

namespace Application\Web;

use MiniFrame\WebApplication\Controller;

class BaseController extends Controller
{
    /**
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        return $this->getDi()->get('twig');
    }

    /**
     * @return \Swift_Mailer
     */
    protected function getSwiftMailer()
    {
        return $this->getDi()->get('swiftmailer');
    }

    /**
     * @return \PDO
     */
    protected function getPdo()
    {
        return $this->getDi()->get('pdo');
    }
}

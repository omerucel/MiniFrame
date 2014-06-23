<?php

namespace MiniFrame\WebApplication;

use MiniFrame\Di\IDi;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller
{
    /**
     * @var IDi
     */
    protected $dependencyInjection;

    /**
     * @param IDi $dependencyInjection
     */
    public function __construct(IDi $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    /**
     * @return null
     */
    public function preDispatch()
    {
        return null;
    }

    /**
     * @return null
     */
    public function postDispatch()
    {
        return null;
    }

    /**
     * @param $url
     * @param int $code
     * @param array $headers
     * @return RedirectResponse
     */
    protected function redirect($url, $code = 302, $headers = array())
    {
        return new RedirectResponse($url, $code, $headers);
    }

    /**
     * @return IDi
     */
    public function getDi()
    {
        return $this->dependencyInjection;
    }
}

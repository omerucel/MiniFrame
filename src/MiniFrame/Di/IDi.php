<?php

namespace MiniFrame\Di;

use Zend\Config\Config;
use Zend\Stdlib\Response;

interface IDi
{
    /**
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function set($name, $value);

    /**
     * @return Config
     */
    public function getConfigs();

    /**
     * @return Response
     */
    public function getHttpResponse();
}

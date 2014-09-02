<?php

namespace Application\Web;

class SayHello extends BaseController
{
    public function get(array $params = [])
    {
        return $this->toPlainText('Hello ' . $params[1]);
    }
}

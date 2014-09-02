<?php

namespace Application\Web;

use Application\Web\Exception\PageNotFound;

class NotFound extends BaseController
{
    public function __call($name, $args = [])
    {
        throw new PageNotFound(
            strtoupper($name) . ' ' . $this->getDi()->get('http_request')->getUri() . ' ' . ' ' . json_encode($args)
        );
    }
}

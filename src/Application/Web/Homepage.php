<?php

namespace Application\Web;

class Homepage extends BaseController
{
    public function get()
    {
        return $this->toHtml($this->getTwig()->render('panel/index.twig'));
    }
}

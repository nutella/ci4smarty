<?php

namespace Ci4Smarty;

use \Smarty;

class Ci4Smarty
{
    protected $smarty;
    
    public function render($args)
    {

        $this->smarty = new Smarty();

    }
}

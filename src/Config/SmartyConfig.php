<?php

namespace Ci4Smarty\Config;

use CodeIgniter\Config\BaseConfig;

class SmartyConfig extends BaseConfig
{
    public static $fileExtension = '.tpl';
    public static $templateDir = APPPATH . 'Views';
    public static $compileDir = WRITEPATH . 'templates_c';
    public static $cacheDir = WRITEPATH . 'caches';
    public static $configDir = APPPATH . 'Views/configs';
}

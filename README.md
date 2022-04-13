# ci4smarty
Integration Codeigniter 4 and Smarty Template Engine 

## Requirements

- PHP 7.3+, 8.0+
- CodeIgniter 4.0.4+
- Smarty 4.1.0+

## Installation

Installation is best done via Composer. Assuming Composer is installed globally, you may use the following command: 

    > composer require maheswara/ci4smarty

## Manual Installation
Otherwise you can install manually:
1. Download **smarty** and **ci4smarty** and put in **app/ThirdParty** folder
    - https://github.com/smarty-php/smarty/archive/refs/tags/v4.1.0.zip
    - https://github.com/jerry-maheswara-github/ci4smarty/archive/refs/tags/v1.0.0.zip

2. Edit and add this line on **app/Config/Autoload.php**

        public $psr4 = [
            'Ci4Smarty'   => APPPATH . 'ThirdParty/ci4smarty-1.0.0/src'
        ];

        public $classmap = [
            'Smarty'   => APPPATH . 'ThirdParty/smarty-4.1.0/libs/Smarty.class.php',
        ];

## Controller
The easy way to implement this, is by extends your controller from **SmartyController**.

    use Ci4Smarty\Controllers\SmartyController;

    class BaseController extends SmartyController{
        
    }

## Config
You can override config by adding file **SmartyConfig.php** to **app/Config** folder and change it

    <?php
        namespace Config;
        use CodeIgniter\Config\BaseConfig;
        class SmartyConfig extends BaseConfig
        {
            public static $fileExtension = '.tpl';
            public static $templateDir = APPPATH . 'Views';
            public static $compileDir = WRITEPATH . 'templates_c';
            public static $cacheDir = WRITEPATH . 'caches';
            public static $configDir = APPPATH . 'Views/configs';
        }

## Feature
This is the feature:
- Auto render template base on Controller class and method like: **home/index** or if url segment is under folder like: **admin/dashboard/index**
- You can also render manually: **$this->render('home/index');**
- If you like to change layout you can add **$this->setLayout('layout');** before render, and add {$content} in the layout file as a container of rendered template;
- You can stop render by **$this->setRendered(true);** if you will debug or print_r your code and eliminate the exception;
- Don't forget the extension of each template file is **.tpl** (smarty)
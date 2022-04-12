<?php

namespace Ci4Smarty\Controllers;

use Ci4Smarty\TemplateEngine as Smarty;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class SmartyController extends Controller
{
    protected $view;
    protected $layout;
    protected $rendered;
    protected $smarty;
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->view = new \stdClass();
        $this->smarty = new Smarty();
        $this->view->content = null;

    }

    public function render($template = null, $data = null, $return = false)
    {
        $ext = \Config\SmartyConfig::$fileExtension;
        if ($template != null) {
            $template = preg_replace('/\s+|.tpl|\s/', '', $template) . $ext;
        } else {
            // $method = get_class_methods($this);
            $segment = $this->request->getUri()->getSegments();
            $defaultMethod = \Config\Services::routes()->getDefaultMethod();
            if ($segment && isset($segment[1])) {
                $method = $segment[1];
            } else {
                $method = $defaultMethod;
            }
            $class = get_called_class();
            $shortClass = (new \ReflectionClass($class))->getShortName();
            $this->view->pageTitle = $shortClass;
            $template = strtolower($shortClass) . DIRECTORY_SEPARATOR . $method . $ext;

            if (isset($segment[0]) && is_dir(APPPATH . 'Controllers/' . $segment[0])) {
                if (isset($segment[2])) {
                    $method = $segment[2];
                } else {
                    $method = $defaultMethod;
                }
                $template = $segment[0] . DIRECTORY_SEPARATOR . strtolower($shortClass) . DIRECTORY_SEPARATOR . $method . $ext;
            }
        }

        $args = array(
            'data' => $data ?: $this->view,
            'layout' => $this->getLayout(),
            'template' => $template,
            'return' => false,
        );
        $this->smarty->render($args);

        $this->setRendered('true');

        // // opn($template, 1, 1);
        // if (isset($data) && $data != null) {
        //     $this->smarty->assign((array) $data);
        // } else {
        //     $this->smarty->assign((array) $this->view);
        // }

        // // if (!empty($this->_config['tplext']) && !strpos($template, '.' . $this->_config['tplext'] . '.tpl')) {
        // //     $template = str_replace('.tpl', '.' . $this->_config['tplext'] . '.tpl', $template);
        // // }

        // if ($return == true) {
        //     return $this->smarty->fetch($this->smarty->getTemplateDir(0) . $template);
        // } else {
        //     if ($this->view->content == null) {
        //         $this->view->content = $this->smarty->fetch($this->smarty->getTemplateDir(0) . $template);
        //         $this->smarty->assign((array) $this->view);
        //     }
        //     if ($force = false) {
        //         $this->smarty->display($this->smarty->getTemplateDir(0) . $this->getLayout() . $ext);
        //     } else {
        //         if ($this->getLayout()) {
        //             $this->smarty->display($this->smarty->getTemplateDir(0) . $this->getLayout() . $ext);
        //         } else {
        //             $this->smarty->display($this->smarty->getTemplateDir(0) . $template);
        //         }
        //     }
        //     $this->setRendered('true');
        // }

    }

    public function __destruct()
    {
        if (!$this->getRendered()) {
            $this->render(null, null, false);
        }
    }

    public function __call($name = '', $arguments = array())
    {
        $methodPrefix = substr($name, 0, 3);
        $property = strtolower(substr($name, 3));
        $methodPrefix != 'set' ?: $this->$property = $arguments[0];
        if ($methodPrefix == 'get') {
            return $this->$property;
        }
    }

}

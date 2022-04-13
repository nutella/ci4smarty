<?php

namespace Ci4Smarty;

use Smarty;

class TemplateEngine extends Smarty
{
    protected $smarty;

    public function render($args = array())
    {
        $this->setTemplateDir(\Ci4Smarty\Config\SmartyConfig::$templateDir);
        $this->setCompileDir(\Ci4Smarty\Config\SmartyConfig::$compileDir);
        $this->setCacheDir(\Ci4Smarty\Config\SmartyConfig::$cacheDir);
        $this->setConfigDir(\Ci4Smarty\Config\SmartyConfig::$configDir);
        $this->setCacheLifetime(30);

        $ext = \Ci4Smarty\Config\SmartyConfig::$fileExtension;
        $template = preg_replace('/\s+|.tpl|\s/', '', $args['template']) . $ext;

        if (isset($args['data']) && $args['data'] != null) {
            if ($args['data']['content'] == null) {
                $this->assign((array) $args['data']);
                $args['data']['content'] = $this->fetch($this->getTemplateDir(0) . $template);
            }
            $this->assign((array) $args['data']);
            if ($args['return'] == true) {
                return $this->fetch($this->getTemplateDir(0) . $template);
            } else {
                if ($args['layout']) {
                    $this->display($this->getTemplateDir(0) . $args['layout'] . $ext);
                } else {
                    $this->display($this->getTemplateDir(0) . $template);
                }
            }
        }

    }
}

<?php
/**
 * Module.php
 *
 * @copyright (c) 2013 Henning Huncke, http://www.devjunkie.de
 */

namespace ZF2ModuleLayouts;

use Zend\Mvc\MvcEvent;

/**
 * Module Class.
 */
class Module
{
    /**
     * Bootstrap of Module.
     *
     * @param MvcEvent $e
     * @return void
     */
    public function onBootstrap(MvcEvent $e)
    {
        $sharedManager = $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this, 'dispatch'), 100);
    }

    /**
     * Callback method for dispatch set on bootstrap.
     *
     * @param MvcEvent $e
     * @return void
     */
    public function dispatch(MvcEvent $e)
    {
        $moduleName = $this->getModuleName($e);
        $config = $this->getConfig($e);
        $layouts = $config['module_layouts'];

        if (isset($layouts[$moduleName])) {
            // set the module specified layout
            $this->setControllerLayout($e, $layouts[$moduleName]);
        }
    }

    /**
     * Returns the configuration.
     *
     * @param MvcEvent $e
     * @return array|Traversable
     */
    private function getConfig(MvcEvent $e)
    {
        $config = $e->getApplication()->getServiceManager()->get('config');

        return $config;
    }

    /**
     * Returns the name of the module.
     *
     * @param MvcEvent $e
     * @return string
     */
    private function getModuleName(MvcEvent $e)
    {
        $controller = $e->getTarget();
        $className = get_class($controller);

        return substr($className, 0, strpos($className, '\\'));
    }

    /**
     * Sets the layout of the controller.
     *
     * @return Module
     */
    private function setControllerLayout(MvcEvent $e, $layout)
    {
        $controller = $e->getTarget();
        $controller->layout($layout);

        return $this;
    }
}
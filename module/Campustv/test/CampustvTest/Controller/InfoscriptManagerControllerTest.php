<?php

namespace CampustvTest\Controller;

use CampustvTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Campustv\Controller\InfoscriptManagerController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class InfoscriptManagerControllerTest extends \PHPUnit_Framework_TestCase {

    const STATUS_OK       = 200;
    const STATUS_REDIRECT = 302;

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp() {
        $serviceManager   = Bootstrap::getServiceManager();
        $this->controller = new InfoscriptManagerController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'manager'));
        $this->event      = new MvcEvent();
        $config           = $serviceManager->get('Config');
        $routerConfig     = isset($config['router']) ? $config['router'] : array();
        $router           = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }


    // <editor-fold defaultstate="collapsed" desc="Test Accessability">
    private function _actionCanBeAccessed($status, $action){
        $this->routeMatch->setParam('action', $action);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals($status, $response->getStatusCode());
    }

    public function testIndexActionCanBeAccessed() {
        $this->_actionCanBeAccessed(self::STATUS_OK, 'index');
    }

    public function testShowInfoscriptActionCanBeAccessed() {
        $this->_actionCanBeAccessed(self::STATUS_OK, 'showInfoscript');
    }

    public function testCreateInfoscriptActionCanBeAccessed() {
        $this->_actionCanBeAccessed(self::STATUS_OK, 'createInfoscript');
    }

    public function testEditInfoscriptActionCanBeAccessed() {
        //STATUS_REDIRECT because edit action redirects to create action if no
        //id is given
        $this->_actionCanBeAccessed(self::STATUS_REDIRECT, 'editInfoscript');
    }

    public function testDeleteInfoscriptActionCanBeAccessed() {
        //STATUS_REDIRECT because delete action redirects to show action if no
        //id is given
        $this->_actionCanBeAccessed(self::STATUS_REDIRECT, 'deleteInfoscript');
    }

// </editor-fold>

    public function testGetService(){

        $this->assertInstanceOf('Campustv\Service\IService', $this->controller->getService('Infoscript'));
        $this->assertInstanceOf('Campustv\Service\IService', $this->controller->getService('Anzeige'));
        $this->assertInstanceOf('Campustv\Service\IService', $this->controller->getService('Url'));
        $this->assertInstanceOf('Campustv\Service\IService', $this->controller->getService('Kunde'));
    }

}
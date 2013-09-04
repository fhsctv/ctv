<?php

namespace LegacyctvTest\Controller;

use LegacyctvTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Legacyctv\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class IndexControllerTest extends \PHPUnit_Framework_TestCase {

    const STATUS_OK       = 200;
    const STATUS_REDIRECT = 302;

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp() {
        $serviceManager   = Bootstrap::getServiceManager();
        $this->controller = new IndexController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config           = $serviceManager->get('Config');
        $routerConfig     = isset($config['router']) ? $config['router'] : array();
        $router           = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }


    public function testAktuelleAnzeigenErmitteln(){

        $aktAnz1 = new \Futhuer\Legacy\AktuelleAnzeigen(41);
        $aktAnz1->createService($this->controller->getServiceLocator());
        $aktAnz1->deprecatedAktuelleAnzeigenErmitteln();

        $aktAnz2 = new \Futhuer\Legacy\AktuelleAnzeigen(41);
        $aktAnz2->createService($this->controller->getServiceLocator());
        $aktAnz2->AktuelleAnzeigenErmitteln();


        $this->assertEquals($aktAnz1->Anzeigen, $aktAnz2->Anzeigen);
    }

    public function testAktuelleAnzeigenInFeld(){

        $aktAnz1 = new \Futhuer\Legacy\AktuelleAnzeigen(41);
        $aktAnz2 = new \Futhuer\Legacy\AktuelleAnzeigen(41);
        $aktAnz1->createService($this->controller->getServiceLocator());
        $aktAnz2->createService($this->controller->getServiceLocator());

        $aktAnz1->deprecatedAktuelleAnzeigenErmitteln();
        $aktAnz2->AktuelleAnzeigenErmitteln();

        $aktAnz1->aktuelleAnzeigenInFeld();
        $aktAnz2->deprecatedAktuelleAnzeigenInFeld();


        $this->assertEquals($aktAnz1->aktAnzeigen, $aktAnz2->aktAnzeigen);
    }

    public function testAktuelleInfoscripteErmitteln(){

        $aktAnz1 = new \Futhuer\Legacy\AktuelleAnzeigen(41);
        $aktAnz2 = new \Futhuer\Legacy\AktuelleAnzeigen(41);
        $aktAnz1->createService($this->controller->getServiceLocator());
        $aktAnz2->createService($this->controller->getServiceLocator());

        $aktAnz1->aktuelleInfoscripteErmitteln();
        $aktAnz2->deprecatedAktuelleInfoscripteErmitteln();

        $this->assertEquals($aktAnz1->Infoscripte, $aktAnz2->Infoscripte);
    }

    public function testAktuelleInfoscripteInFeld(){

        $aktAnz1 = new \Futhuer\Legacy\AktuelleAnzeigen(1);
        $aktAnz1->createService($this->controller->getServiceLocator());
        $aktAnz1->deprecatedaktuelleInfoscripteErmitteln();
        $aktAnz1->deprecatedaktuelleInfoscripteInFeld();

        $aktAnz2 = new \Futhuer\Legacy\AktuelleAnzeigen(1);
        $aktAnz2->createService($this->controller->getServiceLocator());
        $aktAnz2->AktuelleInfoscripteErmitteln();
        $aktAnz2->AktuelleInfoscripteInFeld();


        $this->assertEquals($aktAnz1->aktAnzeigen, $aktAnz2->aktAnzeigen);
    }

    public function testAktuelleAnzeigenUndInfoscripteInFeld(){

        $aktAnz1 = new \Futhuer\Legacy\AktuelleAnzeigen(21);
        $aktAnz1->createService($this->controller->getServiceLocator());
        $aktAnz1->deprecatedAktuelleAnzeigenErmitteln();
        $aktAnz1->deprecatedAktuelleAnzeigenInFeld();
        $aktAnz1->deprecatedaktuelleInfoscripteErmitteln();
        $aktAnz1->deprecatedaktuelleInfoscripteInFeld();

        $aktAnz2 = new \Futhuer\Legacy\AktuelleAnzeigen(21);
        $aktAnz2->createService($this->controller->getServiceLocator());
        $aktAnz2->AktuelleAnzeigenErmitteln();
        $aktAnz2->AktuelleAnzeigenInFeld();
        $aktAnz2->AktuelleInfoscripteErmitteln();
        $aktAnz2->AktuelleInfoscripteInFeld();


        $this->assertEquals($aktAnz1->aktAnzeigen, $aktAnz2->aktAnzeigen);

    }

    public function testIntervallAction(){
        $this->routeMatch->setParam('action', 'intervall');
        $result = $this->controller->dispatch($this->request);

        $response = $this->controller->getResponse();



        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(array('intervall' => 20), $result->getVariables());
        //TODO render viewmodel and check result

    }

    //TODO implement tests for all actions


}
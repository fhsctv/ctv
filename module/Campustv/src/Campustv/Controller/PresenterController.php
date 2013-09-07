<?php

namespace Campustv\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Futhuer\UrlCheck as FuthuerUrlCheck;
use Futhuer\Random   as FuthuerRandom;


class PresenterController extends AbstractActionController {

    /**
     * Duration of the show time for one slide
     */
    const SHOWTIME      = 15;

    /**
     * GET- parameters are defined in the router of the module.config.php.
     * The id - parameter determines which slide has to be shown
     */
    const PARAM_ID      = 'id';

    /**
     * GET- parameters are defined in the router of the module.config.php.
     * The display - parameter determines which display is active
     */
    const PARAM_DISPLAY = 'display';


    public function indexAction() {
        $content = __METHOD__;

        //$channel = \Zend\Feed\Reader\Reader::import('http://www.spiegel.de/schlagzeilen/eilmeldungen/index.rss');
        $channel = \Zend\Feed\Reader\Reader::import('http://www.insuedthueringen.de/storage/rss/rss/th/homepage.xml');



        return new ViewModel(array('content' => $content, 'rss' => $channel));
    }

    public function showAction(){

        $anzeigen    = $this->getService('Anzeige')->fetchAllActive( (int) $this->params(self::PARAM_DISPLAY));

        //"infoscripte" is shown on all displays
        $infoscripte = $this->getService('Infoscript')->fetchAllActive();

        $slides      = $this->mergeSlides($anzeigen, $infoscripte->toArray());

        $id          = $this->getValidId($slides, $this->params(self::PARAM_ID,0));


        $viewModel   = new ViewModel(
                array(
                      'slide'          => $slides[$id]['url'],
                      'headMetaForward' => $this->getHeadMetaForwardingString(
                                            $this->getForwardingUrl($slides, $id)
                                           )
                     )
        );


        return \Futhuer\Layout::disableLayout($viewModel);
    }



    // <editor-fold defaultstate="collapsed" desc="Helpmethods">

    /**
     * mergeSlides merges $anzeigen and $infoscripte into one array
     * @param array $anzeigen
     * @param array $infoscripte
     * @return array
     */
    private function mergeSlides(array $anzeigen, array $infoscripte) {

        return array_merge($anzeigen, $infoscripte);
    }

    /**
     * getValidId determines if a slide has a valid url and returns its
     * id. In case of invalid url, getValidId does the same with the next
     * slide from the array.
     * This avoids 404 error pages during the slide show.
     *
     * @param array $slides array with slides to be presented
     * @param int $id id- parameter from url
     * @return int
     * @see module.config.php
     */
    private function getValidId(array $slides, $id=0) {

        if ($id >= count($slides)) {
            return $this->getValidId($slides, 0);
        }

        if (false === FuthuerUrlCheck::checkUrl($slides[$id]['url']))
            return $this->getValidId($slides, $id + 1);

        return $id;
    }


    /**
     * getForwardingUrl determines the behaviour of the order of the presented
     * slides and generates the url of the next slide
     * @param array $slides
     * @param int $currentId
     * @return string
     */
    private function getForwardingUrl(array $slides, $currentId) {

        $countSlides = count($slides) - 1;
        $randomId    = FuthuerRandom::repeatlessRandom(0, $countSlides, $currentId);
//        $id          = $currentId + 1; //sequentially

        $route      = 'campustv/presenter/default';
        $action     = $this->params('action');
        $display    = (int) $this->params(self::PARAM_DISPLAY);

        return $this->url()->fromRoute($route, array(
                    'action' => $action,
                    self::PARAM_DISPLAY => $display,
                    self::PARAM_ID      => $randomId
            )
        );
    }

    private function getHeadMetaForwardingString($url) {
        return '<meta http-equiv="refresh" content="'
                . self::SHOWTIME
                . '; URL=' . $url . '">';
    }

    // </editor-fold>

    /**
     * Returns model service
     * @param string $name Servicename with upper-case first letter
     * @return object
     * @throws Exception\ServiceNotFoundException
     */
    public function getService($name){

        return $this->getServiceLocator()->get('Campustv\Service\\' . $name);
    }
}

<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Company\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AnzeigeController extends AbstractActionController {

    public function indexAction() {
        $content = 'Content in indexAction';

        return new ViewModel(array('content' => $content));
    }

    public function showAction() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

    public function showActiveAction() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

    public function showActiveDisp1Action() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

    public function showOutdatedAction() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

    public function showFutureAction() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

    public function editAction() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

    public function deleteAction() {
        $content = __METHOD__;

        return new ViewModel(array('content' => $content));
    }

}

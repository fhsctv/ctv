<?php

namespace Administration\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $content = __CLASS__ . __METHOD__ . "<br/>";

        return new ViewModel(array('content' => $content));
    }
}

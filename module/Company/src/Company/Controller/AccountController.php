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

class AccountController extends AbstractActionController
{
    public function indexAction()
    {
        $content = 'Content in indexAction';

        return new ViewModel(array('content' => $content));
    }

    public function showAction(){
        return new ViewModel(array('content' => 'SHOW ACTION'));
    }

    public function editAction(){
        return new ViewModel(array('content' => 'EDIT ACTION'));
    }
}

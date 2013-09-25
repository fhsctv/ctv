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

use Company\Model\Entity;

class AccountController extends AbstractActionController
{
    public function indexAction()
    {
        $content = 'Content in indexAction';

        return new ViewModel(array('content' => $content));
    }

    public function showAction(){


        $anzeigeTable = new \Company\Model\Table\Anzeige(new \Zend\Db\TableGateway\TableGateway('anzeige_new'
                                                        ,$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
                                                        ,null
                                                        ,new \Zend\Db\ResultSet\ResultSet(\Zend\Db\ResultSet\ResultSet::TYPE_ARRAYOBJECT, new \Company\Model\Entity\Anzeige())
            )
        );




        $company = new Entity\Company("MusterUnternehmen GmbH", "Musterstraße", "41", "535783", "Musterstadt");
        $company->getContact()->setPhone('0000/123456');
        $company->getContact()->setFax('0000/7895321');

        return new ViewModel(array(
                'content'  => 'SHOW ACTION',
                'company'  => $company,
                'anzeigen' => $anzeigeTable->fetchAllOutdated(5452)
            )
        );
    }

    public function editAction(){
        return new ViewModel(array('content' => 'EDIT ACTION'));
    }
}

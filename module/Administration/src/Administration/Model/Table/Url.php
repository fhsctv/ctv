<?php

namespace Administration\Model\Table;



use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;


use Administration\Model        as Model;
use Administration\Model\Entity as Entity;

class Url extends AbstractTable {



    /**
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }


    /**
     *
     * @param  Administration\Model\IEntity $urlModel $urlModel
     * @return int id of the new url
     * @todo implement return of id with $this->tableGateway->getLastInsertValue(); when available in ZF2
     */
    public function save(Model\IEntity $urlModel) {

        if(!$urlModel->getUrl()){
            throw new \Exception('Url is required for saving Url!');
        }


        return parent::save($urlModel);

    }


    public function getIdKey() {
        return Entity\Url::TBL_COL_ID;
    }


    //-------------------------------------------------------- PROTECTED METHODS

    protected function getColumns(Select $select) {
        return $select;
    }

    protected function getJoin(Select $select) {
        return $select;
    }
}

?>

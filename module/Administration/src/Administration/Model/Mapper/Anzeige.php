<?php

namespace Administration\Model\Mapper;

use Administration\Model\Entity;
use Futhuer\Date as FuthuerDate;

class Anzeige extends \Zend\Stdlib\Hydrator\ClassMethods {

    public function hydrate(array $data, $anzeige) {

        if(is_array($data[Entity\Anzeige::TBL_COL_DISPLAY_ID])){
            unset($data[Entity\Anzeige::TBL_COL_DISPLAY_ID]);
        }

        $anzeige = parent::hydrate($data, $anzeige);



        $anzeige->setSchaltungsende((new FuthuerDate($anzeige->getSchaltungsanfang()))
                        ->modify(FuthuerDate::OP_ADD, $anzeige->getGebuchteWochen(), FuthuerDate::WEEK)
        );



        return $anzeige->setWahrscheinlichkeit(5)->setImWarenkorb(0);
    }

}

?>

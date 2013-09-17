<?php

namespace Administration\Form\Form;

use Administration\Model\Entity\Infoscript;

use Zend\Form\Form;

class InfoscriptForm extends Form {

    public function __construct($name = null) {

        parent::__construct('infoscript');

        $this->setAttribute('method', 'post');

        $this->add(array(
                'name' => strtolower(Infoscript::TBL_COL_ID),
                'attributes' => array('type' => 'hidden',),
            )
        );
        $this->add(array(
                'name'       => strtolower(Infoscript::TBL_COL_BEGIN_DATE),
                'attributes' => array('type'  => 'text','value' => date('d.m.Y'),),
                'options'    => array('label' => 'Startdatum'),
            )
        );
        $this->add(array(
                'name' => strtolower(Infoscript::TBL_COL_END_DATE),
                'attributes' => array('type'  => 'text','value' => date('d.m.Y'),),
                'options'    => array('label' => 'Ablaufdatum',),
            )
        );
        $this->add(array(
                'name' => strtolower(Infoscript::TBL_COL_URL),
                'attributes' => array('type'  => 'url','value'=>"http://"),
                'options'    => array('label' => 'Url'),
            )
        );
        $this->add(array(
                'name' => 'submit',
                'attributes' => array('type'  => 'submit',
                                      'value' => 'erstellen',
                                      'id'    => 'submitbutton'
                    ),
            )
        );

    }

}

?>

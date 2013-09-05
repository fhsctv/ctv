<?php

namespace Campustv\Form\Form;


use Zend\Form\Form;

class DeleteForm extends Form {

    public function __construct($name = null) {

        parent::__construct('delete');

        $this->setAttribute('method', 'post');

        $this->add(array(
                'name' => 'id',
                'attributes' => array('type' => 'hidden',),
            )
        );

        $this->add(array(
                'name' => 'submit',
                'attributes' => array('type'  => 'submit',
                                      'value' => 'ja',
                                      'id'    => 'submitbutton'
                    ),
            )
        );
        $this->add(array(
                'name' => 'submit',
                'attributes' => array('type'  => 'submit',
                                      'value' => 'nein',
                                      'id'    => 'submitbutton'
                    ),
            )
        );

    }

}

?>

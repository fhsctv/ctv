<?php

namespace Administration\Form\Form;

use Administration\Model\Entity\Anzeige;

use Zend\Form\Form;

class AnzeigeForm extends Form {

    public function __construct($kunden,
                                $selectedCustomer,
                                $displays,
                                $selectedDisplay) {

        parent::__construct('anzeige');

        $this->setAttribute('method', 'post');

        $this->add(array(
                'name' => Anzeige::TBL_COL_ID,
                'attributes' => array('type' => 'hidden',),
            )
        );

        $this->add(array(
            'name' => Anzeige::TBL_COL_BEGIN_DATE,
            'attributes' => array('type' => 'text', 'value' => date('d.m.Y'),),
            'options' => array('label' => 'Schaltungsanfang'),
                )
        );

        $this->add(array(
            'name' => Anzeige::TBL_COL_BOOKED_WEEKS,
            'attributes' => array('type' => 'text', 'value' => 0),
            'options' => array('label' => 'Gebuchte Wochen'),
                )
        );

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => Anzeige::TBL_COL_CUSTOMER_ID,
            'options' => array(
                'label' => 'Kunde',
                'value_options' => $kunden,
            ),
            'attributes' => array(
                'value' => $selectedCustomer,
            )
                )
        );

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => Anzeige::TBL_COL_DISPLAY_ID,
            'options' => array(
                'label' => 'Monitor',
                'value_options' => $displays,
            ),
            'attributes' => array(
                'multiple' => 'multiple',
                'value' => $selectedDisplay,
            )
                )
        );

        $this->add(array(
            'name' => Anzeige::TBL_COL_URL,
            'attributes' => array('type' => 'url', 'value' => "http://"),
            'options' => array('label' => 'Url'),
                )
        );

        $this->add(array(
            'name' => 'submit',
            'attributes' => array('type' => 'submit',
                'value' => 'erstellen',
                'id' => 'submitbutton'
            ),
                )
        );
    }

}

?>

<?php

namespace Administration\Form\Form;

use Administration\Model\Entity\AnzeigeFile as AnzeigeFileModel;

use Zend\Form\Form;

class AnzeigeFileForm extends Form {

    public function __construct() {

        parent::__construct('anzeigefile');

        $this->setAttribute('method', 'post');

        $this->add(array(
                'name' => AnzeigeFileModel::JOB_TITLE,
                'attributes' => array('type' => 'text',),
                'options' => array('label' => AnzeigeFileModel::JOB_TITLE),
            )
        );
//
//        // <editor-fold defaultstate="collapsed" desc="begin_date">
//        $this->add(array(
//            'name' => Anzeige::TBL_COL_BEGIN_DATE,
//            'attributes' => array('type' => 'text', 'value' => date('d.m.Y'),),
//            'options' => array('label' => 'Schaltungsanfang'),
//                )
//        );
//// </editor-fold>
//
//        // <editor-fold defaultstate="collapsed" desc="booked_weeks">
//        $this->add(array(
//            'name' => Anzeige::TBL_COL_BOOKED_WEEKS,
//            'attributes' => array('type' => 'text', 'value' => 0),
//            'options' => array('label' => 'Gebuchte Wochen'),
//                )
//        );
//        // </editor-fold>
//
//        // <editor-fold defaultstate="collapsed" desc="customer">
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => Anzeige::TBL_COL_CUSTOMER_ID,
//            'options' => array(
//                'label' => 'Kunde',
//                'value_options' => $kunden,
//            ),
//            'attributes' => array(
//                'value' => $kundenSelection,
//            )
//                )
//        );
//        // </editor-fold>
//
//        // <editor-fold defaultstate="collapsed" desc="display">
//
////        $this->add(array(
////            'name' => Anzeige::TBL_COL_DISPLAY_ID,
////            'attributes' => array('type' => 'text',),
////            'options' => array('label' => 'Monitor', 'value' => 41),
////                )
////        );
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => Anzeige::TBL_COL_DISPLAY_ID,
//            'options' => array(
//                'label' => 'Monitor',
//                'value_options' => $displays,
//            ),
//            'attributes' => array(
//                'multiple' => 'multiple',
//                'value' => $displaySelection,
//            )
//                )
//        );
//        // </editor-fold>
//
//        // <editor-fold defaultstate="collapsed" desc="url">
//        $this->add(array(
//            'name' => Anzeige::TBL_COL_URL,
//            'attributes' => array('type' => 'url', 'value' => "http://"),
//            'options' => array('label' => 'Url'),
//                )
//        );
//        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="submit">
        $this->add(array(
            'name' => 'submit',
            'attributes' => array('type' => 'submit',
                'value' => 'erstellen',
                'id' => 'submitbutton'
            ),
                )
        ); // </editor-fold>
        }

}

?>

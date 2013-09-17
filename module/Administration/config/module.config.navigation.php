<?php

//$navigation = array(
//    'default' => array(
//        'futhuer' => array(
//            'label' => 'Futhuer',
//            'uri' => 'http://www.futhuer.de',
//            'pages' => array(
//                'old_dia' => array(
//                    'label' => 'Altes Administration',
//                    'uri' => 'http://futhuer.de/ctv/live/CampusTV.html?id=41',
//                ),
//            )
//        ),
//
//    ),
//);
return array(
    'navigation' => array(
        'default' => array(
            'administration' => array(
                'label' => 'Administration',
                'route' => 'administration',
                'controller' => 'Infoscript',
                'action' => 'index',
                'pages' => array(
                    'infoscript' => array(
                        'label' => 'Infoscript',
                        'route' => 'administration/infoscript/default',
                        'controller' => 'Infoscript',
                        'action' => 'show-infoscript',
                    ),
                    'anzeige' => array(
                        'label' => 'Anzeige',
                        'route' => 'administration/anzeige/default',
                        'controller' => 'Anzeige',
                        'action' => 'show-anzeige',
                    ),
                )
            ),
        ),
    )
);

<?php

//$navigation = array(
//    'default' => array(
//        'futhuer' => array(
//            'label' => 'Futhuer',
//            'uri' => 'http://www.futhuer.de',
//            'pages' => array(
//                'old_dia' => array(
//                    'label' => 'Altes Campustv',
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
            'campustv' => array(
                'label' => 'CampusTV',
                'route' => 'campustv',
                'pages' => array(
                    'infoscriptmanager' => array(
                        'label' => 'Infoscript-Manager',
                        'route' => 'campustv/infoscript-manager',
                        'pages' => array(
                            'show-infoscript' => array(
                                'label' => 'Infoscripte',
                                'route' => 'campustv/infoscript-manager/default',
                                'action' => 'show-infoscript',
                            ),
                        )
                    ),
                    'anzeigemanager' => array(
                        'label' => 'Anzeige-Manager',
                        'route' => 'campustv/anzeige-manager',
                        'pages' => array(
                            'show-anzeige' => array(
                                'label' => 'Anzeigen',
                                'route' => 'campustv/anzeige-manager/default',
                                'action' => 'show-anzeige',
                            ),
                            'anzeige-file' => array(
                                'label' => 'Anzeigedatei',
                                'route' => 'campustv/anzeige-manager/default',
                                'action' => 'anzeige-file',
                            )
                        )
                    ),
                    'presenter' => array(
                        'label' => 'Presenter',
                        'route' => 'campustv/presenter',
                        'pages' => array(
                            'mensa' => array(
                                'label' => 'Mensa',
                                'route' => 'campustv/presenter/default',
                                'action' => 'show',
                                'params' => array(
                                    'display' => 1,
                                ),
                            ),
                            'hoersaal' => array(
                                'label' => 'Hörsaalgebäude',
                                'route' => 'campustv/presenter/default',
                                'action' => 'show',
                                'params' => array(
                                    'display' => 21,
                                ),
                            ),
                            'buero' => array(
                                'label' => 'Büro',
                                'route' => 'campustv/presenter/default',
                                'action' => 'show',
                                'params' => array(
                                    'display' => 41,
                                ),
                            ),
                        ),
                    )
                )
            ),
        ),
    )
);

<?php

return array(
    'navigation' => array(
        'default' => array(
            'company' => array(
                'label' => 'Company',
                'route' => 'company',
                'pages' => array(
                    'account' => array(
                        'label' => 'Account',
                        'route' => 'company/default',
                        'controller' => 'account',
                        'action' => 'index',
                        'pages' => array(
                            'show' => array(
                                'label' => 'Show',
                                'route' => 'company/default',
                                'controller' => 'account',
                                'action' => 'show',
                            ),
                            'edit' => array(
                                'label' => 'Edit',
                                'route' => 'company/default',
                                'controller' => 'account',
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'anzeigen' => array(
                        'label' => 'Anzeigen',
                        'route' => 'company/default',
                        'controller' => 'anzeige',
                        'action' => 'index',
                        'pages' => array(
                            'show' => array(
                                'label' => 'Show',
                                'route' => 'company/default',
                                'controller' => 'anzeige',
                                'action' => 'show',
                                'pages' => array(
                                    'active' => array(
                                        'label' => 'Active',
                                        'route' => 'company/default',
                                        'controller' => 'anzeige',
                                        'action' => 'show-active',
                                        'pages' => array(
                                            'disp1' => array(
                                                'label' => 'Display 1',
                                                'route' => 'company/default',
                                                'controller' => 'anzeige',
                                                'action' => 'show-active-disp1',
                                            ),
                                        ),
                                    ),
                                    'outdated' => array(
                                        'label' => 'Outdated',
                                        'route' => 'company/default',
                                        'controller' => 'anzeige',
                                        'action' => 'show-outdated',
                                    ),
                                    'future' => array(
                                        'label' => 'Future',
                                        'route' => 'company/default',
                                        'controller' => 'anzeige',
                                        'action' => 'show-future',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'label' => 'Edit',
                                'route' => 'company/default',
                                'controller' => 'anzeige',
                                'action' => 'edit',
                            ),
                            'delete' => array(
                                'label' => 'Delete',
                                'route' => 'company/default',
                                'controller' => 'anzeige',
                                'action' => 'delete',
                            ),
                        ),
                    ),
                )
            ),
        ),
    )
);

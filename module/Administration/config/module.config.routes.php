<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'active' => true,
                    'defaults' => array(
                        '__NAMESPACE__' => 'Administration\Controller',
                        'controller' => 'Infoscript',
                        'action' => 'index',
                    ),
                ),
            ),
            'administration' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/administration',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Administration\Controller',
                        'controller' => 'IndexController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // <editor-fold defaultstate="collapsed" desc="Presenter Route">
                    'presenter' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/presenter',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Administration\Controller',
                                'controller' => 'Presenter',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '[/:action[/display=:display[/id=:id]]]',
                                    'constraints' => array(
                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'display' => '[0-9]*',
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            ),
                        ),
                    ),
                    // </editor-fold>
                    // <editor-fold defaultstate="collapsed" desc="Anzeige Manager Route">
                    'anzeige' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/anzeige',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Administration\Controller',
                                'controller' => 'Anzeige',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '[/:action[/id=:id]]',
                                    'constraints' => array(
                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            ),
                            'show-anzeige' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '[/:action[/display=:display]]',
                                    'constraints' => array(
                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'display' => '[0-9]*',
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action' => 'show-anzeige',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    // </editor-fold>
                    // <editor-fold defaultstate="collapsed" desc="Infoscript Route">
                    'infoscript' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/infoscript',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Administration\Controller',
                                'controller' => 'Infoscript',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '[/:action[/id=:id]]',
                                    'constraints' => array(
                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            ),
                        ),
                    ),
                // </editor-fold>
                )
            ),
        )
    )
);

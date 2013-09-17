<?php

return array(
    'router' => array(
        'routes' => array(

/*
 * überschreibt das Verhalten beim Aufruf der Wurzel der Internetseite
 * dabei wird dieses Modul als Start- Aufruf- Modul festgelegt.
 */

//            'home' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route'    => '/',
//                    'defaults' => array(
//                        'controller' => 'Generic\Controller\Index',
//                        'action'     => 'index',
//                    ),
//                ),
//            ),

            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /generic/:controller/:action
            'generic' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/generic',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Generic\Controller',
                        'controller'    => 'Generic\Controller\Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

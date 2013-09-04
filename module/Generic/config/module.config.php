<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */


$router = array(
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
    );

$service_manager = array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    );

$translator = array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    );

$controllers = array(
        'invokables' => array(
            'Generic\Controller\Index' => 'Generic\Controller\IndexController'
            //TODO ADD MORE CONTROLLERS
        ),
    );

$view_manager = array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
//        'template_map' => array(
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//            'generic/index/index' => __DIR__ . '/../view/generic/index/index.phtml',
//            'error/404'               => __DIR__ . '/../view/error/404.phtml',
//            'error/index'             => __DIR__ . '/../view/error/index.phtml',
//        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    );

return array(
    'router' => $router,
    'service_manager' => $service_manager,
    'translator'      => $translator,
    'controllers'     => $controllers,
    'view_manager'    => $view_manager
);

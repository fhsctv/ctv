<?php

$service_manager = array(
    'factories' => array(
        'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
    ),
);

$translator = array(
    'locale' => 'de_DE',
    'translation_file_patterns' => array(
        array(
            'type' => 'gettext',
            'base_dir' => __DIR__ . '/../language',
            'pattern' => '%s.mo',
        ),
    ),
);



$view_manager = array(
    'display_not_found_reason' => true,
    'display_exceptions'       => true,
    'doctype'                  => 'HTML5',
    'not_found_template'       => 'error/404',
    'exception_template'       => 'error/index',
    'template_map' => array(
        'layout/layout'                      => __DIR__ . '/../view/layout/layout.phtml',
        'error/404'                          => __DIR__ . '/../view/error/404.phtml',
        'error/index'                        => __DIR__ . '/../view/error/index.phtml',
    ),
//    'template_map' => include __DIR__  .'/../template_map.php',
    'template_path_stack' => array(
        __DIR__ . '/../view',
    ),
);



return array(
    'service_manager' => $service_manager,
    'translator'      => $translator,
    'view_manager'    => $view_manager,
    'constants'       => array('Campustv\ServiceCaching' => false),
);

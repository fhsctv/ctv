<?php

return array(
    'navigation' => array(
        'default' => array(
            'generic' => array(
                'label' => 'Generic',
                'route' => 'generic',
                'pages' => array(
                    'name1' => array(
                        'label' => 'Generic - Child1',
//                        'route' => 'generic/child1/default',
                        'action' => 'child1',
                    ),
                    'name2' => array(
                        'label' => 'Generic - Child2',
//                        'route' => 'generic/child1/default',
                        'action' => 'child1',
                    ),
                )
            ),
        ),
    )
);

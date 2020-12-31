<?php
use Zend\Log\Logger;

return [
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'delegators' => [
            'logger_default' => [
                \Logger\Service\PsrLoggerDelegator::class
            ],
        ]
    ],
    'log' => [
        'logger_default' => [
            'writers' => [
                [
                    'name' => 'stream',
                    'options' => [
                        'stream' => 'data/log/system.log',
                    ]
                ]
            ]
        ],
    ]
];

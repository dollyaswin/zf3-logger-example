<?php
use Zend\Log\Logger;

return [
    'service_manager' => [
        'delegators' => [
            'logger_default' => [
                \Logger\Service\PsrLoggerDelegator::class
            ],
            'logger_db' => [
                \Logger\Service\PsrLoggerDelegator::class
            ],
        ],
        'abstract_factories' => [
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
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

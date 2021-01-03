<?php
use Zend\Log\Logger;

return [
    'service_manager' => [
        'delegators' => [
            'logger_default' => [
                \Logger\Service\PsrLoggerDelegator::class
            ],
        ],
        'abstract_factories' => [
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ]
    ],
];

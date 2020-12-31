<?php
use Zend\Log\Logger;

return [
    'service_manager' => [
        'delegators' => [
            'logger_default' => [
                \Logger\Service\PsrLoggerDelegator::class
            ],
        ]
    ],
];

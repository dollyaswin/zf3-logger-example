<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Logger;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Log\Writer;
use Zend\Log\Logger;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'logger_default' => function ($container) {
                    $dbAdapter = $container->get('logger_db');
                    $mapping = [
                        'priorityName'  => 'priority_name',
                        'priority'  => 'priority',
                        'timestamp' => 'timestamp',
                        'message'   => 'message',
                        'extra' => [
                            'function'  => 'function',
                            'user_id'   => 'user_id',
                            'user_type' => 'user_type',
                            'page' => 'page'
                        ]
                    ];
                    $writerDb = new Writer\Db($dbAdapter, 'log', $mapping);
                    $logger   = new Logger();
                    $logger->addWriter($writerDb, 1);
                    Logger::registerErrorHandler($logger);
                    return $logger;
                }
            ]
        ];
    }
}

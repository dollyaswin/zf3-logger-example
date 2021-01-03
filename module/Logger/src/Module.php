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
use Zend\Mvc\MvcEvent;
use Zend\Log\Filter\Priority;
use Psr\Log\LogLevel;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $application    = $mvcEvent->getApplication();
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $sharedManager  = $application->getEventManager()->getSharedManager();
        $sharedManager->attach(
            'Zend\Mvc\Application',
            'dispatch.error',
            function($e) use ($serviceManager) {
                if ($e->getParam('exception')) {
                    $serviceManager->get('logger_db')
                                   ->log(LogLevel::INFO, $e->getParam('exception'));
                }
            }
        );
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'logger_db' => function ($container) {
                    $dbAdapter = $container->get('logger_db_adapter');
                    $mapping = [
                        'priorityName'  => 'priority_name',
                        'priority'  => 'priority',
                        'timestamp' => 'timestamp',
                        'message'   => 'message',
//                         'extra' => [
//                             'function'  => 'function',
//                             'user_id'   => 'user_id',
//                             'user_type' => 'user_type',
//                             'page' => 'page'
//                         ]
                    ];
                    $writerDb = new Writer\Db($dbAdapter, 'log', $mapping);
                    // filter only CRITICAL log on database
                    $filter   = new Priority(Logger::CRIT);
                    $writerDb->addFilter($filter);
                    $logger   = new Logger();
                    $logger->addWriter($writerDb, 1);
                    Logger::registerErrorHandler($logger);
                    return $logger;
                }
            ]
        ];
    }
}

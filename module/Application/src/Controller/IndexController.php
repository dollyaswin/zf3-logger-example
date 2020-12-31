<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Psr\Log\LoggerAwareTrait;

class IndexController extends AbstractActionController
{
    use LoggerAwareTrait;
    
    public function indexAction()
    {
        $this->logger->log(
            \Psr\Log\LogLevel::INFO,
            '{class}::{function} Logger set up',
            [
                'class'    => __CLASS__,
                'function' => __FUNCTION__,
            ]
        );
        return new ViewModel();
    }
}

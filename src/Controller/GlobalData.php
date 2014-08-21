<?php

/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Magento
 */
namespace jtl\Connector\Magento\Controller;

use jtl\Core\Rpc\Error;
use jtl\Core\Utilities\ClassName;
use jtl\Connector\Model\Statistic;
use jtl\Connector\Result\Action;
use jtl\Connector\Magento\Mapper\GlobalData as GlobalDataMapper;

/**
 * Description of GlobalData
 *
 * @access public
 * @author Christian Spoo <christian.spoo@jtl-software.com>
 */
class GlobalData extends AbstractController
{
    public function push($params)
    {
        
    }

    public function delete($params)
    {
        
    }

    public function pull($filter)
    {
        $action = new Action();
        $action->setHandled(true);
        
        try {
            $mapper = new GlobalDataMapper();
            $data = $mapper->pull($filter);
            
            $action->setResult($data);
        }
        catch (\Exception $exc) {
            $err = new Error();
            $err->setCode($exc->getCode());
            $err->setMessage($exc->getMessage());
            $action->setError($err);
        }
        
        return $action;
    }

    public function statistic($params)
    {
        $action = new Action();
        $action->setHandled(true);
        
        try {
            $mapper = new GlobalDataMapper();
            
            $statistic = new Statistic();
            $statistic->setControllerName(lcfirst(ClassName::getFromNS(get_called_class())));
            $statistic->setAvailable(1); // There can be only one GlobalData container object per shop
            $statistic->setPending(1);

            if ($statistic->_controllerName == 'globalData')
                $statistic->_controllerName = 'global';

            $action->setResult($statistic->getPublic());
        }
        catch (\Exception $exc) {
            $err = new Error();
            $err->setCode($exc->getCode());
            $err->setMessage($exc->getMessage());
            $action->setError($err);
        }
        
        return $action;
    }
}

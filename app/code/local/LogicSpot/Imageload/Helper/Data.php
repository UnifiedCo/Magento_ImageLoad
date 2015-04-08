<?php
/**
 *  LogicSpot_Imageload main helper file
 *
 *
 * @category    LogicSpot
 * @package     LogicSpot_Imageload
 * @copyright   Copyright (c) 2014 LogicSpot (http://www.logicspot.com)
 * @author      Rich Kirk, Kamil Szewczyk <rich@logicspot.com>
 */


class LogicSpot_Imageload_Helper_Data extends Mage_Core_Helper_Data {
    const XML_PATH_ENABLE = 'logicspot_imageload/imageload/enable';

    /**
     * Determine if module is enabled.
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLE);
    }
}
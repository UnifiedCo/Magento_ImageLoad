<?php
/**
 * LogicSpot_ImageLoad
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @category    LogicSpot
 * @package     LogicSpot_ImageLoad
 * @copyright   Copyright (c) 2015 LogicSpot (http://www.logicspot.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License v3.0
 */
/**
 * Main helper class for LogicSpot ImageLoad module
 *
 * Class LogicSpot_ImageLoad_Helper_Data
 */
class LogicSpot_ImageLoad_Helper_Data extends Mage_Core_Helper_Data {
    const XML_PATH_ENABLE = 'logicspot_imageload/imageload/enable';

    /**
     * Determine if module is enabled.
     *
     * @return bool
     */
    public function isModuleEnabled($moduleName = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLE);
    }
}

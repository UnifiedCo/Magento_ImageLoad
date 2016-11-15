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
    const XML_LOADING_METHOD = 'logicspot_imageload/imageload/method';
    const XML_DATA_ATTR_NAME = 'logicspot_imageload/imageload/data_attribute';

    /**
     * Determine if module is enabled.
     *
     * @return bool
     */
    public function isModuleEnabled($moduleName = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLE);
    }

    /**
     * Return module loading method
     *
     * @return bool
     */
    public function getLoadingMethod()
    {
        return Mage::getStoreConfig(self::XML_LOADING_METHOD);
    }

    /**
     * Return data attribute name for Data method
     *
     * @return bool
     */
    public function getDataAttributeName()
    {
        return Mage::getStoreConfig(self::XML_DATA_ATTR_NAME);
    }

    /**
     * Return default hover image for product or throw an error
     *
     * @param Mage_Catalog_Model_Product $product
     * @param int $width Width of the image
     * @param int $height Height of the image
     * @return string|null Url for the hover image
     */
    public function getHoverImage(Mage_Catalog_Model_Product $product, $width, $height = null)
    {
        $hoverImg = $product->getHoverImage();
        if ($hoverImg && $hoverImg != 'no_selection') {
            return (string)Mage::helper('catalog/image')->init($product, 'small_image', $hoverImg)->resize($width, $height);
        }

        $product->load('media_gallery');
        if (!$product->getMediaGalleryImages()) {
            return null;
        }
        /* @var Varien_Data_Collection $image */
        $items = $product->getMediaGalleryImages()->getItems();
        list($image) = array_slice($items, 1, 1);
        if (!$image) {
            return null;
        }

        try {
            $imageObject = new Varien_Image($image->getPath());
        } catch (Exception $e) {
            return null;
        }

        $width = $width > $imageObject->getOriginalWidth() ? $imageObject->getOriginalWidth() : $width;
        $height = $height > $imageObject->getOriginalWidth() ? $imageObject->getOriginalWidth() : $height;

        return (string)Mage::helper('catalog/image')->init($product, 'small_image', $image->getFile())->resize($width, $height);
    }
}

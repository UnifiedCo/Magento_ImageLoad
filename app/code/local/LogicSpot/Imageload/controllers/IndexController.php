<?php
/**
 * LogicSpot_Imageload
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @category    LogicSpot
 * @package     LogicSpot_Imageload
 * @copyright   Copyright (c) 2015 LogicSpot (http://www.logicspot.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License v3.0
 */
/**
 * Main controller file for Imageload module
 *
 * Class LogicSpot_Imageload_IndexController
 */
class LogicSpot_Imageload_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieve product image based on the passed url and return as JSON for AJAX call
     */
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
        $url = str_replace(Mage::getBaseUrl(), '', $params['url']);

        $rewriteModel = Mage::getModel('core/url_rewrite')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->loadByRequestPath($url);

        //get product id from url
        $productId = $rewriteModel->getProductId();
        if (!$productId) {
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('error' => true)));
            return;
        }

        $result = array('error' => false);
        $_product = Mage::getModel('catalog/product')->load($productId);
        //Get default hover image
        $hoverImg = $_product->getHoverImage();
        /** @var Varien_Data_Collection $image */
        $items = $_product->getMediaGalleryImages()->getItems();
        list($image) = array_slice($items, 1, 1);
        if ($hoverImg && $hoverImg != 'no_selection') {
            $result['img'] = (string)Mage::helper('catalog/image')->init($_product, 'small_image', $hoverImg)->resize($params['width']);
        } else if ($image) {
            $result['img'] = (string)Mage::helper('catalog/image')->init($_product, 'small_image', $image->getFile())->resize($params['width']);
        } else {
            $result['error'] = true;
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}

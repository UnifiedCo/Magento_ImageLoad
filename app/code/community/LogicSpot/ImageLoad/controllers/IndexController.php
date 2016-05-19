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
 * Main controller file for ImageLoad module
 *
 * Class LogicSpot_ImageLoad_IndexController
 */
class LogicSpot_ImageLoad_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieve product image based on the passed url and return as JSON for AJAX call
     */
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
		$url = trim(parse_url($params['url'], PHP_URL_PATH), '/');

		//check if url have id part in it
		$urlParts = explode('/', $url);
		if ($i = array_search('id', $urlParts)) {
			$productId = $urlParts[$i + 1];
		} else {
			//try to get the url from rewritten url
			$rewriteModel = Mage::getModel('core/url_rewrite')
				->setStoreId(Mage::app()->getStore()->getId())
				->loadByRequestPath(array_pop($urlParts));

			//get product id from url
			$productId = $rewriteModel->getProductId();
		}


		$result = array('error' => false);
        $_product = Mage::getModel('catalog/product')->load($productId);

		if (!$_product->getId()) {
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('error' => true)));
			return;
		}

        //Get default hover image
        $hoverImg = $_product->getHoverImage();
        /** @var Varien_Data_Collection $image */
        $items = $_product->getMediaGalleryImages()->getItems();
        list($image) = array_slice($items, 1, 1);

		$imageObject = new Varien_Image($image->getPath());

		$width = $params['width'] > $imageObject->getOriginalWidth() ? $imageObject->getOriginalWidth() : $params['width'];

        if ($hoverImg && $hoverImg != 'no_selection') {
            $result['img'] = (string)Mage::helper('catalog/image')->init($_product, 'small_image', $hoverImg)->resize($width);
        } else if ($image) {
            $result['img'] = (string)Mage::helper('catalog/image')->init($_product, 'small_image', $image->getFile())->resize($width);
        } else {
            $result['error'] = true;
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}

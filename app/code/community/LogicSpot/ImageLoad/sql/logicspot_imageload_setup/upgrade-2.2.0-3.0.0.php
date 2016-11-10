<?php
$installer = $this;
$installer->startSetup();

$installer->updateAttribute('catalog_product', 'hover_image', 'used_in_product_listing', '1');

$installer->endSetup();
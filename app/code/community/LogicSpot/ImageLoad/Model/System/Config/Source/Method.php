<?php

class LogicSpot_ImageLoad_Model_System_Config_Source_Method
{
    const HOVER = 1;
    const TEMPLATE = 2;
    const DATA = 3;
    const PAGELOAD = 3;

    public function toOptionArray()
    {
        return array(
            array('value' => self::HOVER, 'label' => Mage::helper('imageload')->__('Hover')),
            array('value' => self::DATA, 'label' => Mage::helper('imageload')->__('Data attribute')),
        );
    }
}
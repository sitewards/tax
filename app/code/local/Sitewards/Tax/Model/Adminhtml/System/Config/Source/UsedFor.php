<?php

/**
 * @category  Sitewards
 * @package   Sitewards_Tax
 * @copyright Copyright (c) Sitewards GmbH (http://www.sitewards.com/)
 */
class Sitewards_Tax_Model_Adminhtml_System_Config_Source_UsedFor
{
    public function toOptionArray()
    {
        return [
            [
                'value' => Sitewards_Tax_Helper_Data::S_TAX_USED_FOR_UNDEFINED,
                'label' => Mage::helper('sitewards_tax/data')->__('Please Select')
            ],
            [
                'value' => Sitewards_Tax_Helper_Data::S_TAX_USED_FOR_PRODUCTS,
                'label' => Mage::helper('sitewards_tax/data')->__('Products')
            ],
            [
                'value' => Sitewards_Tax_Helper_Data::S_TAX_USED_FOR_SHIPPING,
                'label' => Mage::helper('sitewards_tax/data')->__('Shipping')
            ]
        ];
    }
}

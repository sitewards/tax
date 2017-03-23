<?php

/**
 * @category  Sitewards
 * @package   Sitewards_Tax
 * @copyright Copyright (c) Sitewards GmbH (http://www.sitewards.com/)
 */
class Sitewards_Tax_Block_Adminhtml_Tax_Class_Edit_Form extends Mage_Adminhtml_Block_Tax_Class_Edit_Form
{
    /**
     * Overridden to add an additional field to be edited for each tax class
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();

        /** @var Mage_Tax_Model_Class $oModel */
        $oModel     = Mage::registry('tax_class');
        $sClassType = $this->getClassType();

        // We only want to apply the additional field to the product type tax rates
        if ($sClassType === Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER) {
            return;
        }

        $oForm = $this->getForm();

        $oFieldset = $oForm->addFieldset(
            'import_data',
            array(
                'legend' => Mage::helper('sitewards_tax/data')->__('Product Import')
            )
        );

        $oFieldset->addField(
            'used_for',
            'select',
            [
                'name'     => 'used_for',
                'label'    => 'Used For',
                'id'       => 'used-for',
                'title'    => Mage::helper('sitewards_tax/data')->__('Used For'),
                'value'    => $oModel->getUsedFor(),
                'required' => false,
                'values'   => Mage::getModel('sitewards_tax/adminhtml_system_config_source_usedFor')->toOptionArray()
            ]
        );

        $this->setForm($oForm);

        return $this;
    }
}

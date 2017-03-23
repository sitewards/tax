<?php

/**
 * @category  Sitewards
 * @package   Sitewards_Tax
 * @copyright Copyright (c) Sitewards GmbH (http://www.sitewards.com/)
 */

class Sitewards_Tax_Model_Resource_Setup extends Mage_Tax_Model_Resource_Setup
{
    /**
     * @var string[]
     */
    private $aRequiredProperties = [
        'name',
        'type',
        'used_for'
    ];

    /**
     * Save all the given tax classes
     *
     * @param array<string> $aTaxClasses
     * @throws Exception
     * @throws Sitewards_Tax_Model_Exception_NoTaxClassesGiven
     * @throws Sitewards_Tax_Model_Exception_TaxClassNotValid
     */
    public function addTaxClasses(array $aTaxClasses)
    {
        if (empty($aTaxClasses)) {
            throw new Sitewards_Tax_Model_Exception_NoTaxClassesGiven();
        }

        foreach ($aTaxClasses as $aTaxClass) {
            // Ensure all required information exists.
            foreach ($this->aRequiredProperties as $sProperty) {
                if (!isset($aTaxClass[$sProperty])) {
                    throw new Sitewards_Tax_Model_Exception_TaxClassNotValid(
                        sprintf("Tax class declaration is missing '%s'", $sProperty)
                    );
                }
            }

            /** @var Mage_Tax_Model_Class $oTaxClass */
            $oTaxClass = Mage::getModel('tax/class');
            $oTaxClass->load($aTaxClass['name'], 'class_name');
            $oTaxClass->setClassName($aTaxClass['name']);
            $oTaxClass->setClassType($aTaxClass['type']);
            $oTaxClass->setUsedFor($aTaxClass['used_for']);
            $oTaxClass->save();
        }
    }

    /**
     * Save all the given tax rate calculations for the given countries
     *
     * @param string[] $aCountries
     * @param array<string,string> $aTaxCalculationRates
     * @throws Exception
     * @throws Sitewards_Tax_Model_Exception_NoCountriesGiven
     * @throws Sitewards_Tax_Model_Exception_NoTaxCalculationRatesGiven
     * @throws Sitewards_Tax_Model_Exception_TaxCalculationRateNotValid
     */
    public function addTaxCalculationRates(array $aCountries, array $aTaxCalculationRates)
    {
        if (empty($aCountries)) {
            throw new Sitewards_Tax_Model_Exception_NoCountriesGiven();
        }
        if (empty($aTaxCalculationRates)) {
            throw new Sitewards_Tax_Model_Exception_NoTaxCalculationRatesGiven();
        }

        foreach ($aCountries as $sCountry) {
            foreach ($aTaxCalculationRates as $aTaxCalculationRate) {
                if (
                    !isset($aTaxCalculationRate['label'])
                    || !isset($aTaxCalculationRate['region_id'])
                    || !isset($aTaxCalculationRate['rate'])
                ) {
                    throw new Sitewards_Tax_Model_Exception_TaxCalculationRateNotValid();
                }
                $sCode = $sCountry . ' - ' . $aTaxCalculationRate['label'];

                /** @var Mage_Tax_Model_Calculation_Rate $oTaxRate */
                $oTaxRate = Mage::getModel('tax/calculation_rate');
                $oTaxRate->loadByCode($sCode);
                $oTaxRate->setTaxCountryId($sCountry);
                $oTaxRate->setTaxRegionId($aTaxCalculationRate['region_id']);
                $oTaxRate->setTaxPostcode('*');
                $oTaxRate->setCode($sCode);
                $oTaxRate->setRate($aTaxCalculationRate['rate']);
                $oTaxRate->save();
            }
        }
    }

    /**
     * Save all the given tax calculation rules
     *
     * @param array $aTaxCalculationRules
     * @throws Exception
     * @throws Sitewards_Tax_Model_Exception_NoTaxCalculationRulesGiven
     * @throws Sitewards_Tax_Model_Exception_TaxCalculationRuleValid
     */
    public function addTaxCalculationRules(array $aTaxCalculationRules)
    {
        if (empty($aTaxCalculationRules)) {
            throw new Sitewards_Tax_Model_Exception_NoTaxCalculationRulesGiven();
        }

        foreach ($aTaxCalculationRules as $aTaxCalculationRule) {
            if (
                !isset($aTaxCalculationRule['code'])
                || !isset($aTaxCalculationRule['priority'])
                || !isset($aTaxCalculationRule['position'])
                || !isset($aTaxCalculationRule['rates'])
                || !isset($aTaxCalculationRule['customer_class'])
                || !isset($aTaxCalculationRule['product_class'])
            ) {
                throw new Sitewards_Tax_Model_Exception_TaxCalculationRuleValid();
            }

            /** @var Mage_Tax_Model_Calculation_Rule $oTaxRule */
            $oTaxRule = Mage::getModel('tax/calculation_rule');
            $oTaxRule->load($aTaxCalculationRule['code'], 'code');
            $oTaxRule->setCode($aTaxCalculationRule['code']);
            $oTaxRule->setPriority($aTaxCalculationRule['priority']);
            $oTaxRule->setPosition($aTaxCalculationRule['position']);
            $oTaxRule->setTaxRate($aTaxCalculationRule['rates']);
            $oTaxRule->setTaxCustomerClass($aTaxCalculationRule['customer_class']);
            $oTaxRule->setTaxProductClass($aTaxCalculationRule['product_class']);
            $oTaxRule->save();
        }
    }

    /**
     * Get the tax rate ids from a set of given codes
     *
     * @param string[] $aTaxRateCodes
     * @return int[]
     * @throws Sitewards_Tax_Model_Exception_NoTaxRateCodesGiven
     */
    public function getTaxRateIds(array $aTaxRateCodes)
    {
        if (empty($aTaxRateCodes)) {
            throw new Sitewards_Tax_Model_Exception_NoTaxRateCodesGiven();
        }

        /** @var Mage_Tax_Model_Resource_Calculation_Rate_Collection $oTaxRates */
        $oTaxRates = Mage::getModel('tax/calculation_rate')->getCollection();
        $oTaxRates->addFieldToFilter(
            'code',
            [
                'in' => $aTaxRateCodes
            ]
        );

        $aTaxRates = [];
        foreach ($oTaxRates->toOptionArray() as $aTaxRate) {
            $aTaxRates[] = $aTaxRate['value'];
        }
        return $aTaxRates;
    }

    /**
     * Get the tax class ids from a given set of names
     *
     * @param string $sClassType
     * @param string[] $aClassNames
     * @return int[]
     * @throws Sitewards_Tax_Model_Exception_NoTaxClassNamesGiven
     */
    public function getTaxClassIds($sClassType = Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT, array $aClassNames)
    {
        if (empty($aClassNames)) {
            throw new Sitewards_Tax_Model_Exception_NoTaxClassNamesGiven();
        }

        /** @var Mage_Tax_Model_Resource_Class_Collection $oTaxClasses */
        $oTaxClasses = Mage::getModel('tax/class')->getCollection();
        $oTaxClasses->setClassTypeFilter($sClassType);
        $oTaxClasses->addFieldToFilter('class_name', $aClassNames);

        $aTaxClassOptions = [];
        foreach ($oTaxClasses->toOptionArray() as $aTaxOption) {
            $aTaxClassOptions[] = $aTaxOption['value'];
        }
        return $aTaxClassOptions;
    }
}
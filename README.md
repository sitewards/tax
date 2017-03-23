Sitewards_Tax
=============

This extension provides the option to save tax information via a setup script using `Sitewards_Tax_Model_Resource_Setup`

How to use
---

Firstly you will need to create a Magento module with a setup script using `Sitewards_Tax_Model_Resource_Setup`.
This class will give you access to the following methods.

* `addTaxClasses`,
* `addTaxCalculationRates`,
* `addTaxCalculationRules`,
* `getTaxRateIds`,
* `getTaxClassIds`,

These methods will allow you to create tax values with a simple array format.

**Method: addTaxClasses**

This method is used to create tax classes in the Magento system.
It takes an array containing tax class name and type.

```
$installer->addTaxClasses(
    [
        [
            'name' => 'IVA 22%',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT
        ],
        [
            'name' => 'IVA 10%',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT
        ],
        [
            'name' => 'IVA 4%',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT
        ],
        [
            'name' => 'Spedizione',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT
        ],
        [
            'name' => 'Clienti privati',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER
        ],
        [
            'name' => 'Imprese',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER
        ],
        [
            'name' => 'Imprese esenti IVA',
            'type' => Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER
        ],
    ]
);
```

**Method: addTaxCalculationRates**

This method will allow you to like country codes with tax calculations.
It takes 2 arrays, first array is of country codes.
Second array contains region, postcode, label and tax rate.

```
$taxCalculationRates = [
    [
        'region_id' => 0,
        'postcode' => '*',
        'label' => 'IVA 22%',
        'rate' => 22
    ],
    [
        'region_id' => 0,
        'postcode' => '*',
        'label' => 'IVA 10%',
        'rate' => 10
    ],
    [
        'region_id' => 0,
        'postcode' => '*',
        'label' => 'IVA 4%',
        'rate' => 4
    ],
    [
        'region_id' => 0,
        'postcode' => '*',
        'label' => 'IVA 0%',
        'rate' => 0
    ],
];

$euCountries = explode(',', Mage::getStoreConfig('general/country/eu_countries'));
$installer->addTaxCalculationRates($euCountries, $taxCalculationRates);
```

**Method: addTaxCalculationRules**

This method is used to build the tax calculation rules in Magento.
It takes an array containing code, priority, position, rates, customer class and product class.

```
$taxCalculationRules = [
    [
        'code' => 'IVA 22%',
        'priority' => 1,
        'position' => 0,
        'rates' => $this->getTaxRateIds(
            [
                'AT - IVA 22%',
                'BE - IVA 22%',
                'BG - IVA 22%',
                'HR - IVA 22%',
                'CY - IVA 22%',
                'CZ - IVA 22%',
                'DK - IVA 22%',
                'EE - IVA 22%',
                'FI - IVA 22%',
                'FR - IVA 22%',
                'DE - IVA 22%',
                'GR - IVA 22%',
                'HU - IVA 22%',
                'IE - IVA 22%',
                'IT - IVA 22%',
                'LV - IVA 22%',
                'LT - IVA 22%',
                'LU - IVA 22%',
                'MT - IVA 22%',
                'NL - IVA 22%',
                'PL - IVA 22%',
                'PT - IVA 22%',
                'RO - IVA 22%',
                'SK - IVA 22%',
                'SI - IVA 22%',
                'ES - IVA 22%',
                'SE - IVA 22%',
                'GB - IVA 22%',
            ]
        ),
        'customer_class' => $this->getTaxClassIds(
            Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER,
            ['Clienti privati', 'Imprese', 'Endkunden']
        ),
        'product_class' => $this->getTaxClassIds(
            Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT,
            ['IVA 22%', 'Spedizione']
        )
    ],
    [
        'code' => 'IVA 10%',
        'priority' => 2,
        'position' => 0,
        'rates' => $this->getTaxRateIds(
            [
                'AT - IVA 10%',
                'BE - IVA 10%',
                'BG - IVA 10%',
                'HR - IVA 10%',
                'CY - IVA 10%',
                'CZ - IVA 10%',
                'DK - IVA 10%',
                'EE - IVA 10%',
                'FI - IVA 10%',
                'FR - IVA 10%',
                'DE - IVA 10%',
                'GR - IVA 10%',
                'HU - IVA 10%',
                'IE - IVA 10%',
                'IT - IVA 10%',
                'LV - IVA 10%',
                'LT - IVA 10%',
                'LU - IVA 10%',
                'MT - IVA 10%',
                'NL - IVA 10%',
                'PL - IVA 10%',
                'PT - IVA 10%',
                'RO - IVA 10%',
                'SK - IVA 10%',
                'SI - IVA 10%',
                'ES - IVA 10%',
                'SE - IVA 10%',
                'GB - IVA 10%',
            ]
        ),
        'customer_class' => $this->getTaxClassIds(
            Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER,
            ['Clienti privati', 'Imprese', 'Endkunden']
        ),
        'product_class' => $this->getTaxClassIds(
            Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT,
            ['IVA 10%']
        )
    ],
    [
        'code' => 'IVA 4%',
        'priority' => 3,
        'position' => 0,
        'rates' => $this->getTaxRateIds(
            [
                'AT - IVA 4%',
                'BE - IVA 4%',
                'BG - IVA 4%',
                'HR - IVA 4%',
                'CY - IVA 4%',
                'CZ - IVA 4%',
                'DK - IVA 4%',
                'EE - IVA 4%',
                'FI - IVA 4%',
                'FR - IVA 4%',
                'DE - IVA 4%',
                'GR - IVA 4%',
                'HU - IVA 4%',
                'IE - IVA 4%',
                'IT - IVA 4%',
                'LV - IVA 4%',
                'LT - IVA 4%',
                'LU - IVA 4%',
                'MT - IVA 4%',
                'NL - IVA 4%',
                'PL - IVA 4%',
                'PT - IVA 4%',
                'RO - IVA 4%',
                'SK - IVA 4%',
                'SI - IVA 4%',
                'ES - IVA 4%',
                'SE - IVA 4%',
                'GB - IVA 4%',
            ]
        ),
        'customer_class' => $this->getTaxClassIds(
            Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER,
            ['Clienti privati', 'Imprese', 'Endkunden']
        ),
        'product_class' => $this->getTaxClassIds(
            Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT,
            ['IVA 4%']
        )
    ]
];
$installer->addTaxCalculationRules($taxCalculationRules);
```

**Method: getTaxRateIds**

This method will return an array on tax rate ids based from a given set of tax codes.

```
$installer->getTaxRateIds(
    [
        'AT - IVA 4%',
        'BE - IVA 4%',
        'BG - IVA 4%',
        'HR - IVA 4%',
        'CY - IVA 4%',
        'CZ - IVA 4%',
        'DK - IVA 4%',
        'EE - IVA 4%',
        'FI - IVA 4%',
        'FR - IVA 4%',
        'DE - IVA 4%',
        'GR - IVA 4%',
        'HU - IVA 4%',
        'IE - IVA 4%',
        'IT - IVA 4%',
        'LV - IVA 4%',
        'LT - IVA 4%',
        'LU - IVA 4%',
        'MT - IVA 4%',
        'NL - IVA 4%',
        'PL - IVA 4%',
        'PT - IVA 4%',
        'RO - IVA 4%',
        'SK - IVA 4%',
        'SI - IVA 4%',
        'ES - IVA 4%',
        'SE - IVA 4%',
        'GB - IVA 4%',
    ]
);
```

**Method: getTaxClassIds**

This method returns an array of tax class ids matching a class type and array of class names.

```
$installer->getTaxClassIds(
    Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER,
    ['Clienti privati', 'Imprese', 'Endkunden']
)
```
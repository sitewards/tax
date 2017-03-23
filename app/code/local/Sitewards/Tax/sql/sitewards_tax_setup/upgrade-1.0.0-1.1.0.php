<?php

/**
 * @category  Sitewards
 * @package   Sitewards_Tax
 * @copyright Copyright (c) Sitewards GmbH (http://www.sitewards.com/)
 */

/** @var Sitewards_Tax_Model_Resource_Setup $this */
$this->startSetup();

$sTable = $this->getTable('tax/tax_class');
$this->getConnection()
    ->addColumn(
        $sTable,
        'used_for',
        [
            'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
            'nullable' => true,
            'length'   => 16,
            'after'    => null,
            'comment'  => 'What to use this tax rate on; products or shipping'
        ]
    );

$this->endSetup();

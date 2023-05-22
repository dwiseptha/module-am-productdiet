<?php
/**
 * @category Awalmula
 * @package  Awalmula_ProductDiet
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Dwi Septha Kurniawan <dwi.septha@awalmula.co.id>
 *
 * Copyright © 2020 Awal Mula. All rights reserved.
 * http://www.awalmula.co.id
 */

namespace Awalmula\ProductDiet\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection = $setup->getConnection();

            $tableName  = $setup->getTable('am_product_diet');
            $columnName = 'link_click_slider';

            if ($connection->tableColumnExists($tableName, $columnName) === false) {
                $connection->addColumn($tableName, $columnName, array(
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => null,
                    'default' => null,
                    'comment' => 'Link Click',
                ));
            }

            $columnName = 'image_slider';

            if ($connection->tableColumnExists($tableName, $columnName) === false) {
                $connection->addColumn($tableName, $columnName, array(
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => null,
                    'default' => null,
                    'comment' => 'Image Slider',
                ));
            }
        }

        $setup->endSetup();
    }
}

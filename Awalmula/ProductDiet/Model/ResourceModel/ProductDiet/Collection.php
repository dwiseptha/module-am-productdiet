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
namespace Awalmula\ProductDiet\Model\ResourceModel\ProductDiet;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'ampd_id';

    /**
     * Collection initialisation
     */
    protected function _construct()
    {
        $this->_init(
            'Awalmula\ProductDiet\Model\ProductDiet',
            'Awalmula\ProductDiet\Model\ResourceModel\ProductDiet'
        );
    }
}

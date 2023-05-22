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
namespace Awalmula\ProductDiet\Api;

use Awalmula\ProductDiet\Api\Data\ProductDietInterface;

/**
 * @api
 */
interface ProductDietRepositoryInterface
{
    /**
     * Save page.
     *
     * @param ProductDietInterface $ProductDiet
     * @return ProductDietInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ProductDietInterface $productdiet);

    /**
     * 
     * Get ProductDiet Collection
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductDietCollection();

    /**
     * Retrieve Product Diet.
     *
     * @param int $productdietId
     * @return ProductDietInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($productdietId);

    /**
     * Delete Product Diet.
     *
     * @param ProductDietInterface $productdiet
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ProductDietInterface $productdiet);

    /**
     * Delete Product Diet by ID.
     *
     * @param int $productdietId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($productdietId);
}

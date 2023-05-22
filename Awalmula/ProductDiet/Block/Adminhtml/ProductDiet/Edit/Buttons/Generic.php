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
namespace Awalmula\ProductDiet\Block\Adminhtml\ProductDiet\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Awalmula\ProductDiet\Api\ProductDietRepositoryInterface;

class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ProductDietRepositoryInterface
     */
    protected $productdietRepository;

    /**
     * @param Context $context
     * @param ProductDietRepositoryInterface $productdietRepository
     */
    public function __construct(
        Context $context,
        ProductDietRepositoryInterface $productdietRepository
    ) {
        $this->context = $context;
        $this->productdiettRepository = $productdietRepository;
    }

    /**
     * Return ProductDiet ID
     *
     * @return int|null
     */
    public function getProductDietId()
    {
        try {
            return $this->productdietRepository->getById(
                $this->context->getRequest()->getParam('ampd_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

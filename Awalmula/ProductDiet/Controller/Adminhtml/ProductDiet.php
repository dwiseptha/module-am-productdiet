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
namespace Awalmula\ProductDiet\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Awalmula\ProductDiet\Api\ProductDietRepositoryInterface;

abstract class ProductDiet extends Action
{
    /**
     * @var string
     */
    const ACTION_RESOURCE = 'Awalmula_ProductDiet::productdiet';

    /**
     * ProductDiet repository
     *
     * @var ProductDietRepositoryInterface
     */
    protected $productdietRepository;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Result Page Factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Date filter
     *
     * @var Date
     */
    protected $dateFilter;

    /**
     * Sliders constructor.
     *
     * @param Registry $registry
     * @param ProductDietRepositoryInterface $productdietRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        ProductDietRepositoryInterface $productdietRepository,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context
    ) {
        parent::__construct($context);
        $this->coreRegistry             = $registry;
        $this->productdietRepository    = $productdietRepository;
        $this->resultPageFactory        = $resultPageFactory;
        $this->dateFilter               = $dateFilter;
    }
}

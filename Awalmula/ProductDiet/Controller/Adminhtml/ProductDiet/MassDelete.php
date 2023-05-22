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
namespace Awalmula\ProductDiet\Controller\Adminhtml\ProductDiet;

use Awalmula\ProductDiet\Api\ProductDietRepositoryInterface;
use Awalmula\ProductDiet\Controller\Adminhtml\ProductDiet;
use Awalmula\ProductDiet\Model\ResourceModel\ProductDiet\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends ProductDiet
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var string
     */
    protected $successMessage;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * MassAction constructor.
     *
     * @param Registry $registry
     * @param ProductDietRepositoryInterface $productdietRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param $successMessage
     * @param $errorMessage
     */
    public function __construct(
        Registry                       $registry,
        ProductDietRepositoryInterface $productdietRepository,
        PageFactory                    $resultPageFactory,
        Date                           $dateFilter,
        Context                        $context,
        Filter                         $filter,
        CollectionFactory              $collectionFactory,
                                       $successMessage,
                                       $errorMessage
    ) {
        parent::__construct($registry, $productdietRepository, $resultPageFactory, $dateFilter, $context);
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->successMessage    = $successMessage;
        $this->errorMessage      = $errorMessage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Awalmula_ProductDiet::productdiet_massdelete');
    }

    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection     = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $productdiet) {
                $eavAttribute = $this->_objectManager->create('Magento\Eav\Model\Config');
                $attribute    = $eavAttribute->getAttribute('catalog_product', 'am_product_diet');

                $options                                        = $attribute->getSource()->getAllOptions();
                $options['value'][$productdiet->getOptionId()]  = true;
                $options['delete'][$productdiet->getOptionId()] = true;

                $setupObject = $this->_objectManager->create('Magento\Eav\Setup\EavSetup');
                $setupObject->addAttributeOption($options);

                $this->productdietRepository->delete($productdiet);
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __($this->errorMessage));
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('productdiet/productdiet');
        return $redirectResult;
    }
}

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

use Awalmula\ProductDiet\Controller\Adminhtml\ProductDiet;

class Index extends ProductDiet
{

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Awalmula_ProductDiet::productdiet_index');
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Awalmula_ProductDiet::productdiet');
        $resultPage->getConfig()->getTitle()->prepend(__('Product Diets'));
        $resultPage->addBreadcrumb(__('Product Diets'), __('Product Diets'));
        return $resultPage;
    }
}

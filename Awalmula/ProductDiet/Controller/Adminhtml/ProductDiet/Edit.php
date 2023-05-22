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

class Edit extends ProductDiet
{

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Awalmula_ProductDiet::productdiet_edit');
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $imageId    = $this->getRequest()->getParam('ampd_id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Awalmula_ProductDiet::productdiet')
                   ->addBreadcrumb(__('Product Diet'), __('Product Diet'))
                   ->addBreadcrumb(__('Manage Product Diet'), __('Manage Product Diet'));

        if ($imageId === null) {
            $resultPage->addBreadcrumb(__('New Product Diet'), __('New Product Diet'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Product Diet'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Product Diet'), __('Edit Product Diet'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Product Diet'));
        }
        return $resultPage;
    }
}

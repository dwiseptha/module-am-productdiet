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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends ProductDiet
{

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Awalmula_ProductDiet::productdiet_delete');
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $productdietId  = $this->getRequest()->getParam('ampd_id');
        if ($productdietId) {
            try {
                $model        = $this->productdietRepository->getById($productdietId);
                $eavAttribute = $this->_objectManager->create('Magento\Eav\Model\Config');
                $attribute    = $eavAttribute->getAttribute('catalog_product', 'am_product_diet');

                $options                                  = $attribute->getSource()->getAllOptions();
                $options['value'][$model->getOptionId()]  = true;
                $options['delete'][$model->getOptionId()] = true;

                $setupObject = $this->_objectManager->create('Magento\Eav\Setup\EavSetup');
                $setupObject->addAttributeOption($options);

                $this->productdietRepository->deleteById($productdietId);
                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));
                $resultRedirect->setPath('productdiet/productdiet/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The item no longer exists.'));
                return $resultRedirect->setPath('productdiet/productdiet/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('productdiet/productdiet/index', ['ampd_id' => $productdietId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the item'));
                return $resultRedirect->setPath('productdiet/productdiet/edit', ['ampd_id' => $productdietId]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find the item to delete.'));
        $resultRedirect->setPath('productdiet/productdiet/index');
        return $resultRedirect;
    }
}

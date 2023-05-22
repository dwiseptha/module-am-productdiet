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

use Awalmula\ProductDiet\Api\Data\ProductDietInterface;
use Awalmula\ProductDiet\Api\Data\ProductDietInterfaceFactory;
use Awalmula\ProductDiet\Api\ProductDietRepositoryInterface;
use Awalmula\ProductDiet\Controller\Adminhtml\ProductDiet;
use Awalmula\ProductDiet\Model\Uploader;
use Awalmula\ProductDiet\Model\UploaderPoool;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Message\Manager;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;

class Save extends ProductDiet
{
    /**
     * @var Manager
     */
    protected $messageManager;

    /**
     * @var ProductDietRepositoryInterface
     */
    protected $productdietRepository;

    /**
     * @var ProductDietInterfaceFactory
     */
    protected $productdietFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var UploaderPoool
     */
    protected $uploaderPoool;

    /**
     * Save constructor.
     *
     * @param Registry $registry
     * @param ProductDietRepositoryInterface $productdietRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Manager $messageManager
     * @param ProductDietInterfaceFactory $productdietFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPoool $uploaderPoool
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        Registry                                  $registry,
        ProductDietRepositoryInterface            $productdietRepository,
        PageFactory                               $resultPageFactory,
        Date                                      $dateFilter,
        Manager                                   $messageManager,
        ProductDietInterfaceFactory               $productdietFactory,
        DataObjectHelper                          $dataObjectHelper,
        UploaderPoool                             $uploaderPoool,
        Context                                   $context
    ) {
        parent::__construct($registry, $productdietRepository, $resultPageFactory, $dateFilter, $context);
        $this->messageManager        = $messageManager;
        $this->productdietFactory    = $productdietFactory;
        $this->productdietRepository = $productdietRepository;
        $this->dataObjectHelper      = $dataObjectHelper;
        $this->uploaderPoool         = $uploaderPoool;
        $this->_objectManager        = $objectManager;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Awalmula_ProductDiet::productdiet_save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // die();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('ampd_id');
            if ($id) {
                $model = $this->productdietRepository->getById($id);
            } else {
                unset($data['ampd_id']);
                $model = $this->productdietFactory->create();
            }

            try {
                if (!$id) {
                    $image = $this->getUploader('productdiet')->uploadFileAndGetName('image', $data);
                    $imageSlider = $this->getUploader('productdiet')->uploadFileAndGetName('image_slider', $data);
                } else {
                    $image = $this->getUploader('productdiet')->uploadFileAndGetName('image', $data);
                    $imageSlider = $this->getUploader('productdiet')->uploadFileAndGetName('image_slider', $data);
                    if ($image == "Image") {
                        $image = $model->getImage();
                    }

                    if ($imageSlider == "ImageSlider") {
                        $imageSlider = $model->getImageSlider();
                    }
                }
                $data['image']      = $image;
                $data['image_slider'] = $imageSlider;
                $data['status']     = 1;
                $data['sort_order'] = 1;

                // $action = $this->productdietRepository();

                $this->dataObjectHelper->populateWithArray($model, $data, ProductDietInterface::class);
                $action = $this->productdietRepository->save($model);

                $dataPrdctBnft = $this->productdietRepository->getById($action->getId());
                $optionId      = $this->saveOption('am_product_diet', $dataPrdctBnft->getName(), (int) $dataPrdctBnft->getOptionId());
                $dataPrdctBnft->setOptionId($optionId);
                $dataPrdctBnft->save();

                $this->messageManager->addSuccessMessage(__('You saved this Product Diet.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['ampd_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __('Something went wrong while saving the Product Diet:' . $e->getMessage())
                );
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['ampd_id' => $this->getRequest()->getParam('ampd_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPoool->getUploader($type);
    }

    protected function saveOption($attributeCode, $label, $value)
    {
        $attribute = $this->_objectManager->create('Magento\Catalog\Api\ProductAttributeRepositoryInterface')->get($attributeCode);
        $options   = $attribute->getOptions();
        $values    = array();
        foreach ($options as $option) {
            if ($option->getValue() != '') {
                $values[] = (int) $option->getValue();
            }
        }
        if (!in_array($value, $values)) {
            return $this->addAttributeOption(
                [
                    'attribute_id' => $attribute->getAttributeId(),
                    'order' => [0],
                    'value' => [
                        [
                            0 => $label,
                        ],
                    ],
                ]
            );
        } else {
            return $this->updateAttributeOption($value, $label);
        }
    }

    protected function addAttributeOption($option)
    {
        $oId              = 0;
        $setup            = $this->_objectManager->create('Magento\Framework\Setup\ModuleDataSetupInterface');
        $optionTable      = $setup->getTable('eav_attribute_option');
        $optionValueTable = $setup->getTable('eav_attribute_option_value');
        if (isset($option['value'])) {
            foreach ($option['value'] as $optionId => $values) {
                $intOptionId = (int) $optionId;
                if (!$intOptionId) {
                    $data = [
                        'attribute_id' => $option['attribute_id'],
                        'sort_order' => isset($option['order'][$optionId]) ? $option['order'][$optionId] : 0,
                    ];
                    $setup->getConnection()->insert($optionTable, $data);
                    $intOptionId = $setup->getConnection()->lastInsertId($optionTable);
                    $oId         = $intOptionId;
                }
                $condition = ['option_id =?' => $intOptionId];
                $setup->getConnection()->delete($optionValueTable, $condition);
                foreach ($values as $storeId => $value) {
                    $data = ['option_id' => $intOptionId, 'store_id' => $storeId, 'value' => $value];
                    $setup->getConnection()->insert($optionValueTable, $data);
                }
            }
        }
        return $oId;
    }

    protected function updateAttributeOption($optionId, $value)
    {
        $oId              = $optionId;
        $setup            = $this->_objectManager->create('Magento\Framework\Setup\ModuleDataSetupInterface');
        $optionValueTable = $setup->getTable('eav_attribute_option_value');
        $data             = ['value' => $value];
        $setup->getConnection()->update($optionValueTable, $data, ['option_id=?' => $optionId]);
        return $oId;
    }
}

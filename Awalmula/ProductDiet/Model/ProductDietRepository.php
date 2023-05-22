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
namespace Awalmula\ProductDiet\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Awalmula\ProductDiet\Api\ProductDietRepositoryInterface;
use Awalmula\ProductDiet\Api\Data\ProductDietInterface;
use Awalmula\ProductDiet\Api\Data\ProductDietInterfaceFactory;
use Awalmula\ProductDiet\Model\ResourceModel\ProductDiet as ResourceProductDiet;
use Awalmula\ProductDiet\Model\ResourceModel\ProductDiet\CollectionFactory as ProductDietCollectionFactory;

class ProductDietRepository implements ProductDietRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceProductDiet
     */
    protected $resource;

    /**
     * @var ProductDietCollectionFactory
     */
    protected $productdietCollectionFactory;

    /**
     * @var ProductDietInterfaceFactory
     */
    protected $productdietInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    public function __construct(
        ResourceProductDiet $resource,
        ProductDietCollectionFactory $productdietCollectionFactory,
        ProductDietInterfaceFactory $productdietInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->productdietCollectionFactory = $productdietCollectionFactory;
        $this->productdietInterfaceFactory = $productdietInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param ProductDietInterface $productdiet
     * @return ProductDietInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductDietInterface $productdiet)
    {
        try {
            /** @var ProductDietInterface|\Magento\Framework\Model\AbstractModel $productdiet */
            $this->resource->save($productdiet);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the image: %1',
                $exception->getMessage()
            ));
        }
        return $productdiet;
    }

    /**
     * Get ProductDiet Collection
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getProductDietCollection()
    {
        $productdiet = $this->productdietCollectionFactory->create();

        $result = [];

        foreach($productdiet as $value){
            if($value->getImageSliderUrl() && $value->getLinkClickSlider()){
                $result[] = [
                    'name' => $value->getName(),
                    'image' => $value->getImageUrl(),
                    'image_slider' => $value->getImageSliderUrl(),
                    'link_click_slider' => $value->getLinkClickSlider(),
                    'description' => $value->getDescription()
                ];
            }
        }
        // if (!$productdiet->getId()) {
            // throw new NoSuchEntityException(__('Requested doesn\'t exist'));
        // }
            
        return $result;
    }

    /**
     * Get ProductDiet record
     *
     * @param $productdietId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($productdietId)
    {
        if (!isset($this->instances[$productdietId])) {
            $productdiet = $this->productdietInterfaceFactory->create();
            $this->resource->load($productdiet, $productdietId);
            if (!$productdiet->getId()) {
                throw new NoSuchEntityException(__('Requested image doesn\'t exist'));
            }
            $this->instances[$productdietId] = $productdiet;
        }
        return $this->instances[$productdietId];
    }

    /**
     * @param ProductDietInterface $productdiet
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(ProductDietInterface $productdiet)
    {
        /** @var \Awalmula\ProductDiet\Api\Data\ProductDietInterface|\Magento\Framework\Model\AbstractModel $productdiet */
        $id = $productdiet->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($productdiet);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove product diet %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * @param $productdietId
     * @return bool
     */
    public function deleteById($productdietId)
    {
        $productdiet = $this->getById($productdietId);
        return $this->delete($productdiet);
    }
}

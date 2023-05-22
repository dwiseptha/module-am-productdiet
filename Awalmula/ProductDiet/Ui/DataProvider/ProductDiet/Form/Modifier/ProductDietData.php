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
namespace Awalmula\ProductDiet\Ui\DataProvider\ProductDiet\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Awalmula\ProductDiet\Model\ResourceModel\ProductDiet\CollectionFactory;

class ProductDietData implements ModifierInterface
{
    /**
     * @var \Awalmula\ProductDiet\Model\ResourceModel\ProductDiet\Collection
     */
    protected $collection;

    /**
     * @param CollectionFactory $productdietCollectionFactory
     */
    public function __construct(
        CollectionFactory $productdietCollectionFactory
    ) {
        $this->collection = $productdietCollectionFactory->create();
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    /**
     * @param array $data
     * @return array|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function modifyData(array $data)
    {
        $items = $this->collection->getItems();
        /** @var $productdiet \Awalmula\ProductDiet\Model\ProductDiet */
        foreach ($items as $productdiet) {
            $_data = $productdiet->getData();

            if (isset($_data['image'])) {
                $productdietArr = [];
                $productdietArr[0]['name'] = 'Image';
                $productdietArr[0]['url'] = $productdiet->getImageUrl();
                $_data['image'] = $productdietArr;
            }
            if (isset($_data['image_slider'])) {
                $productdietArrSlider = [];
                $productdietArrSlider[0]['name'] = 'Image Slider';
                $productdietArrSlider[0]['url'] = $productdiet->getImageSliderUrl();
                $_data['image_slider'] = $productdietArrSlider;
            }
            $productdiet->setData($_data);
            $data[$productdiet->getId()] = $_data;
        }
        return $data;
    }
}

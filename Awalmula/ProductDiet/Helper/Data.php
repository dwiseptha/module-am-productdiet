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

namespace Awalmula\ProductDiet\Helper;

use Awalmula\ProductDiet\Api\Data\ProductDietInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Helper Data
 *
 */
class Data extends \Magento\Framework\Url\Helper\Data
{

    /**
     * @var ProductDietInterface
     */
    protected $productDiet;

    public function __construct(
        ProductDietInterface $productDiet,
        \Awalmula\ProductDiet\Model\UploaderPoool $uploaderPoool,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->productDiet    = $productDiet;
        $this->eavConfig      = $eavConfig;
        $this->uploaderPoool  = $uploaderPoool;
    }

    /**
     * Get Data Product Diet
     *
     * @return string
     */
    public function getDataProductDietByOptionId($id)
    {
        $data = null;
        try{
            if ($id) {
                $datas = $this->productDiet->getCollection()->addFieldToFilter('option_id', $id);
                foreach($datas as $value){
                    $data = $value;
                }
            }
        } catch (NoSuchEntityException $e) {    
            return $data;
        }

        return $data;
    }

    /**
     * Get Image URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl($data)
    {
        $url = false;
        $image = $data['image'];
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPoool->getUploader('productdiet');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Get Image Slider URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageSliderUrl($data)
    {
        $url = false;
        $image = $data['image_slider'];
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPoool->getUploader('productdiet');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

}
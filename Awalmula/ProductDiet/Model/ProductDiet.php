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

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Awalmula\ProductDiet\Api\Data\ProductDietInterface;

class ProductDiet extends AbstractModel implements ProductDietInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'am_product_diet';

    /**
     * @var UploaderPoool
     */
    protected $uploaderPoool;

    /**
     * Sliders constructor.
     * @param Context $context
     * @param Registry $registry
     * @param UploaderPoool $uploaderPoool
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UploaderPoool $uploaderPoool,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->uploaderPoool    = $uploaderPoool;
    }

    /**
     * Initialise resource model
     * @codingStandardsIgnoreStart
     */
    protected function _construct()
    {
        // @codingStandardsIgnoreEnd
        $this->_init('Awalmula\ProductDiet\Model\ResourceModel\ProductDiet');
    }

    /**
     * Get cache identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(ProductDietInterface::NAME);
    }

    /**
     * Set Name
     *
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(ProductDietInterface::NAME, $name);
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(ProductDietInterface::IMAGE);
    }

    /**
     * Set Image
     *
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(ProductDietInterface::IMAGE, $image);
    }

    /**
     * Get Image Slider
     *
     * @return string
     */
    public function getImageSlider()
    {
        return $this->getData(ProductDietInterface::IMAGE_SLIDER);
    }

    /**
     * Set Image Slider
     *
     * @param $image
     * @return $this
     */
    public function setImageSlider($image)
    {
        return $this->setData(ProductDietInterface::IMAGE_SLIDER, $image);
    }

    /**
     * Get Link Click Slider
     *
     * @return string
     */
    public function getLinkClickSlider()
    {
        return $this->getData(ProductDietInterface::LINK_CLICK_SLIDER);
    }

    /**
     * Set Link Click Slider
     *
     * @param $url
     * @return $this
     */
    public function setLinkClickSlider($url)
    {
        return $this->setData(ProductDietInterface::LINK_CLICK_SLIDER, $url);
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(ProductDietInterface::DESCRIPTION);
    }

    /**
     * Set Description
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(ProductDietInterface::DESCRIPTION, $description);
    }

    /**
     * Get Option Id
     *
     * @return string
     */
    public function getOptionId()
    {
        return $this->getData(ProductDietInterface::OPTION_ID);
    }

    /**
     * Set Option Id
     *
     * @param $optionId
     * @return $this
     */
    public function setOptionId($optionId)
    {
        return $this->setData(ProductDietInterface::OPTION_ID, $optionId);
    }

    /**
     * Get Image URL
     *
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
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
    public function getImageSliderUrl()
    {
        $url = false;
        $image = $this->getImageSlider();
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

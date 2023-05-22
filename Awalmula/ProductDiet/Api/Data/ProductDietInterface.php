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
namespace Awalmula\ProductDiet\Api\Data;

/**
 * @api
 */
interface ProductDietInterface
{
    const PRODUCTDIET_ID    = 'ampd_id';
    const NAME              = 'name';
    const IMAGE             = 'image';
    const DESCRIPTION       = 'description';
    const OPTION_ID         = 'option_id';
    const IMAGE_SLIDER      = 'image_slider';
    const LINK_CLICK_SLIDER = 'link_click_slider';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get Image
     *
     * @return string
     */
    public function getImage();

    /**
     * Get Image Slider
     *
     * @return string
     */
    public function getImageSlider();

    /**
     * Get Image
     *
     * @return string
     */
    public function getImageUrl();

    /**
     * Get Image Slider
     *
     * @return string
     */
    public function getImageSliderUrl();

    /**
     * Get Image
     *
     * @return string
     */
    public function getLinkClickSlider();    

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription();    

    /**
     * Get Option Id
     *
     * @return string
     */
    public function getOptionId();   

    /**
     * Set ID
     *
     * @param $id
     * @return ProductDietInterface
     */
    public function setId($id);

    /**
     * Set Name
     *
     * @param $name
     * @return ProductDietInterface
     */
    public function setName($name);
    
    /**
     * Set image_slider
     *
     * @param $image
     * @return ProductDietInterface
     */
    public function setImageSlider($image);

    /**
     * Set link_click_slider
     *
     * @param $url
     * @return ProductDietInterface
     */
    public function setLinkClickSlider($url);

    /**
     * Set image
     *
     * @param $image
     * @return ProductDietInterface
     */
    public function setImage($image);    

    /**
     * Set Description
     *
     * @param $description
     * @return ProductDietInterface
     */
    public function setDescription($description);

    /**
     * Set Option Id
     *
     * @param $optionId
     * @return ProductDietInterface
     */
    public function setOptionId($optionId);
}

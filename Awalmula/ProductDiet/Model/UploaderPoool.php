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

use Magento\Framework\ObjectManagerInterface;

class UploaderPoool
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $uploaders;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $uploaders
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        array $uploaders = []
    ) {
        $this->objectManager = $objectManager;
        $this->uploaders     = $uploaders;
    }

    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    public function getUploader($type)
    {
        if (!isset($this->uploaders[$type])) {
            throw new \Exception("Uploader not found for type: ".$type);
        }
        if (!is_object($this->uploaders[$type])) {
            $this->uploaders[$type] = $this->objectManager->create($this->uploaders[$type]);
        }
        $uploader = $this->uploaders[$type];
        if (!($uploader instanceof Uploader)) {
            throw new \Exception("Uploader for type {$type} not instance of ". Uploader::class);
        }
        return $uploader;
    }
}

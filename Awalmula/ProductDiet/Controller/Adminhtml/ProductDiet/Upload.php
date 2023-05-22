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

use Awalmula\ProductDiet\Model\Uploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Upload extends Action
{
    /**
     * @var string
     */
    const ACTION_RESOURCE = 'Awalmula_ProductDiet::productdiet';

    /**
     * @var Uploader
     */
    protected $uploader;

    /**
     * Upload constructor.
     *
     * @param Context $context
     * @param Uploader $uploader
     */
    public function __construct(
        Context  $context,
        Uploader $uploader
    ) {
        parent::__construct($context);
        $this->uploader = $uploader;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Awalmula_ProductDiet::productdiet_upload');
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->uploader->saveFileToTmpDir($this->getFieldName());

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * @return string
     */
    protected function getFieldName()
    {
        return $this->_request->getParam('field');
    }
}

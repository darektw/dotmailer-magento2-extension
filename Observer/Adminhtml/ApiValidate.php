<?php

namespace Dotdigitalgroup\Email\Observer\Adminhtml;

use Magento\Config\Model\ResourceModel\Config;
use Dotdigitalgroup\Email\Model\Sync\DummyRecordsFactory;

/**
 * Validate api when saving credentials in admin.
 */
class ApiValidate implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Dotdigitalgroup\Email\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private $context;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * @var \Dotdigitalgroup\Email\Model\Apiconnector\Test
     */
    private $test;

    /**
     * @var DummyRecordsFactory
     */
    private $dummyRecordsFactory;

    /**
     * @var Config
     */
    private $resourceConfig;

    /**
     * @param \Dotdigitalgroup\Email\Helper\Data $data
     * @param \Dotdigitalgroup\Email\Model\Apiconnector\Test $test
     * @param \Magento\Backend\App\Action\Context $context
     * @param DummyRecordsFactory $dummyRecordsFactory
     * @param Config $resourceConfig
     */
    public function __construct(
        \Dotdigitalgroup\Email\Helper\Data $data,
        \Dotdigitalgroup\Email\Model\Apiconnector\Test $test,
        \Magento\Backend\App\Action\Context $context,
        DummyRecordsFactory $dummyRecordsFactory,
        Config $resourceConfig
    ) {
        $this->test           = $test;
        $this->helper         = $data;
        $this->context        = $context;
        $this->messageManager = $context->getMessageManager();
        $this->dummyRecordsFactory = $dummyRecordsFactory;
        $this->resourceConfig = $resourceConfig;
    }

    /**
     * Execute method.
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $groups = $this->context->getRequest()->getPost('groups');

        if (isset($groups['api']['fields']['username']['inherit'])
            || isset($groups['api']['fields']['password']['inherit'])
        ) {
            $this->deleteApiEndpoint();
            return $this;
        }

        $apiUsername = $groups['api']['fields']['username']['value'] ?? false;
        $apiPassword = $groups['api']['fields']['password']['value'] ?? false;

        if ($apiUsername && $apiPassword) {
            $isValidAccount = $this->isValidAccount($apiUsername, $apiPassword);
            if ($isValidAccount) {
                $websiteId = $this->context->getRequest()->getParam('website');

                if ($websiteId) {
                    $this->dummyRecordsFactory->create()
                    ->syncForWebsite($websiteId);

                    return $this;
                }

                $this->dummyRecordsFactory->create()
                    ->sync();
            }
        }

        return $this;
    }

    /**
     * Validate account
     *
     * @param string $apiUsername
     * @param string $apiPassword
     * @return bool
     */
    private function isValidAccount(string $apiUsername, string $apiPassword): bool
    {
        $this->helper->log('----VALIDATING ACCOUNT---');

        if ($this->test->validate($apiUsername, $apiPassword)) {
            $this->messageManager->addSuccessMessage(__('API Credentials Valid.'));
            return true;
        }

        $this->messageManager->addWarningMessage(__('Authorization has been denied for this request.'));
        return false;
    }

    /**
     * Deletes api endpoint if default value is used.
     * @return void
     */
    private function deleteApiEndpoint()
    {
        $websiteId = $this->context->getRequest()->getParam('website');

        $scope = 'default';
        $scopeId = '0';

        if ($websiteId) {
            $scope = 'websites';
            $scopeId = $websiteId;
        }

        $this->resourceConfig->deleteConfig(
            \Dotdigitalgroup\Email\Helper\Config::PATH_FOR_API_ENDPOINT,
            $scope,
            $scopeId
        );
    }
}

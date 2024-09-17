<?php

namespace Dotdigitalgroup\Email\Model\ResourceModel\Importer;

use Dotdigitalgroup\Email\Model\Importer as ImporterModel;
use Dotdigitalgroup\Email\Model\ResourceModel\Importer;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Initialize resource collection.
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Dotdigitalgroup\Email\Model\Importer::class,
            \Dotdigitalgroup\Email\Model\ResourceModel\Importer::class
        );
    }

    /**
     * Reset collection.
     *
     * @return void
     */
    public function reset()
    {
        $this->_reset();
    }

    /**
     * Get imports marked as importing for one or more websites.
     *
     * @param array $websiteIds
     * @param array $types
     * @param bool $useFile
     * @param string $mode
     * @return $this|boolean
     */
    public function getItemsWithImportingStatus(
        $websiteIds,
        array $types,
        bool $useFile = false,
        string $mode = ImporterModel::MODE_BULK
    ) {
        $collection = $this->addFieldToFilter(
            'import_status',
            ['eq' => \Dotdigitalgroup\Email\Model\Importer::IMPORTING]
        )
            ->addFieldToFilter('import_mode', ['eq'=> $mode])
            ->addFieldToFilter('import_id', ['neq' => ''])
            ->addFieldToFilter(
                'website_id',
                ['in' => $websiteIds]
            );

        $importTypeFilter = [
            ['in' => $types]
        ];

        if (in_array('Catalog', $types)) {
            $importTypeFilter[] = ['like' => '%Catalog%'];
        }

        $this->addFieldToFilter('import_type', $importTypeFilter);

        if ($useFile) {
            $this->addFieldToFilter('import_file', ['neq' => '']);
        }

        if ($collection->getSize()) {
            return $collection;
        }

        return false;
    }

    /**
     * Get the imports by type and mode.
     *
     * @param string|array $importType
     * @param string|array $importMode
     * @param int $limit
     * @param array $websiteIds
     * @param bool $useFile
     *
     * @return $this
     */
    public function getQueueByTypeAndMode($importType, $importMode, $limit, $websiteIds, $useFile = false)
    {
        if (is_array($importType)) {
            $condition = [];
            foreach ($importType as $type) {
                if ($type == 'Catalog') {
                    $condition[] = ['like' => $type . '%'];
                } else {
                    $condition[] = ['eq' => $type];
                }
            }
            $this->addFieldToFilter('import_type', $condition);
        } else {
            $this->addFieldToFilter(
                'import_type',
                ['eq' => $importType]
            );
        }

        $this->addFieldToFilter('import_mode', ['in' => $importMode])
            ->addFieldToFilter(
                'import_status',
                ['eq' => \Dotdigitalgroup\Email\Model\Importer::NOT_IMPORTED]
            );

        $this->addFieldToFilter('website_id', ['in' => $websiteIds]);

        if ($useFile) {
            $this->addFieldToFilter('import_file', ['neq' => '']);
        }

        $this->setPageSize($limit)
            ->setCurPage(1);

        return $this;
    }

    /**
     * Fetch tasks with error status.
     *
     * Search the email_importer table for jobs with import_status = 3 (failed),
     * with a created_at time inside the specified time window.
     *
     * @param array $timeWindow
     * @return $this
     */
    public function fetchImporterTasksWithErrorStatusInTimeWindow($timeWindow)
    {
        return $this->addFieldToSelect(['import_type', 'import_mode', 'website_id', 'message', 'created_at'])
            ->addFieldToFilter('import_status', 3)
            ->addFieldToFilter('created_at', $timeWindow)
            ->setOrder('created_at', 'DESC');
    }

    /**
     * Fetch importer data by id.
     *
     * @param string $importId
     * @return \Magento\Framework\DataObject
     */
    public function getImporterDataByImportId($importId)
    {
        return $this->addFieldToSelect(['import_data', 'retry_count'])
            ->addFieldToFilter('import_id', $importId)
            ->getFirstItem();
    }
}

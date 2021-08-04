<?php

declare(strict_types=1);

namespace MageCustom\Customer\Model;

use MageCustom\Customer\Api\Data\AllowAddDescriptionInterface;
use MageCustom\Customer\Model\ResourceModel;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class AllowAddDescriptionRepository
{
    /**
     * @var ResourceModel\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ResourceModel\AllowAddDescription
     */
    private $allowAddDescriptionResource;
    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;
    /**
     * @var AllowAddDescriptionFactory
     */
    private $allowAddDescriptionFactory;

    public function __construct(
        ResourceModel\AllowAddDescription $allowAddDescriptionResource,
        ResourceModel\AllowAddDescription\CollectionFactory $collectionFactory,
        DataObjectProcessor $dataObjectProcessor,
        AllowAddDescriptionFactory $allowAddDescriptionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->allowAddDescriptionResource = $allowAddDescriptionResource;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->allowAddDescriptionFactory = $allowAddDescriptionFactory;
    }

    private function isModel(AllowAddDescriptionInterface $subject): AllowAddDescription
    {
        return $subject instanceof AllowAddDescription ?
            $subject :
            $this->convertToDtoModel($subject);
    }

    private function convertToDtoModel(AllowAddDescriptionInterface $allowAddDescription): AllowAddDescription
    {
        $data = $this->dataObjectProcessor->buildOutputDataArray($allowAddDescription, AllowAddDescriptionInterface::class);
        $optionModel = $this->allowAddDescriptionFactory->create();
        $optionModel->setData($data);

        return $optionModel;
    }

    /**
     * @param $customerEmail
     * @return AllowAddDescription
     * @throws NoSuchEntityException
     */
    public function getOptionByEmail($customerEmail): AllowAddDescription
    {
        $items = $this->collectionFactory->create();
        $items->addFieldToFilter('customer_email', $customerEmail);

        if ($items->count() > 0) {
            /** @var AllowAddDescription $item */
            $item = $items->getFirstItem();
            return $item;
        }

        throw new NoSuchEntityException();
    }

    public function deleteOptionByEmail($customerEmail): void
    {
        $items = $this->collectionFactory->create();
        $items->addFieldToFilter('customer_email', $customerEmail);
        $items->walk('delete');
    }

    public function setOptionByEmail($customerEmail, AllowAddDescriptionInterface $item): void
    {
        try {
            $existingItem = $this->getOptionByEmail($customerEmail);
            if ($existingItem) {
                $this->allowAddDescriptionResource->delete($this->isModel($item));
            }
        } catch (NoSuchEntityException $exception) {
        }

        $item->setCustomerEmail($customerEmail);
        $this->allowAddDescriptionResource->save($this->isModel($item));
    }

    public function getOptionsByEmails(...$customerEmails): array
    {
        $items = $this->collectionFactory->create();
        $items->addFieldToFilter('customer_email', ['in' => $customerEmails]);

        return $items->getItems();
    }
}

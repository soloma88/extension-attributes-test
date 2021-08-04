<?php

declare(strict_types=1);

namespace MageCustom\Customer\Plugin;

use MageCustom\Customer\Api\Data\AllowAddDescriptionInterface;
use MageCustom\Customer\Model\AllowAddDescriptionRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\NoSuchEntityException;

class AllowAddDescriptionPlugin
{
    /**
     * @var AllowAddDescriptionRepository
     */
    private $addDescriptionRepository;

    public function __construct(AllowAddDescriptionRepository $addDescriptionRepository)
    {
        $this->addDescriptionRepository = $addDescriptionRepository;
    }

    public function afterGet(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $this->populateAllowAddDescription($result->getEmail(), $result->getExtensionAttributes());

        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $this->populateAllowAddDescription($result->getEmail(), $result->getExtensionAttributes());

        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param callable $proceed
     * @param CustomerInterface $customer
     * @param null $passwordHash
     * @return CustomerInterface
     */
    public function aroundSave(
        CustomerRepositoryInterface $subject,
        callable $proceed,
        CustomerInterface $customer,
        $passwordHash = null
    ): CustomerInterface {
        $option = $customer->getExtensionAttributes()->getAllowAddDescription();

        $result = $proceed($customer, $passwordHash);

        if ($option) {
            $this->addDescriptionRepository->setOptionByEmail($customer->getEmail(), $option);
        } else {
            $this->addDescriptionRepository->deleteOptionByEmail($customer->getEmail());
        }

        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param SearchResults $result
     * @return SearchResults
     */
    public function afterGetList(
        CustomerRepositoryInterface $subject,
        SearchResults $result
    ): SearchResults {
        /** @var CustomerInterface[] $customers */
        $customers = array_reduce($result->getItems(), static function (array $map, CustomerInterface $customer) {
            $customerEmail = $customer->getEmail();
            $map[$customerEmail] = $customer;
            return $map;
        }, []);
        /** @var AllowAddDescriptionInterface[] $options */
        $options = $this->addDescriptionRepository->getOptionsByEmails(...array_keys($customers));
        foreach ($options as $option) {
            $customerEmail = $option->getCustomerEmail();
            $customers[$customerEmail]->getExtensionAttributes()->setAllowAddDescription($option);
        }

        return $result;
    }

    /**
     * @param $customerEmail
     * @param CustomerExtensionInterface $extensionAttributes
     */
    private function populateAllowAddDescription($customerEmail, CustomerExtensionInterface $extensionAttributes): void
    {
        if ($extensionAttributes->getAllowAddDescription()) {
            return;
        }

        try {
            $option = $this->addDescriptionRepository->getOptionByEmail($customerEmail);
            $extensionAttributes->setAllowAddDescription($option);
        } catch (NoSuchEntityException $exception) {
        }
    }
}

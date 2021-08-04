<?php

declare(strict_types=1);

namespace MageCustom\Customer\Model;

use MageCustom\Customer\Api\Data\AllowAddDescriptionInterface;
use MageCustom\Customer\Model\ResourceModel\AllowAddDescription as AllowAddDescriptionResource;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class AllowAddDescription extends AbstractExtensibleModel implements AllowAddDescriptionInterface
{
    protected function _construct()
    {
        $this->_init(AllowAddDescriptionResource::class);
    }

    /**
     * @param $customerEmail
     */
    public function setCustomerEmail($customerEmail): void
    {
        $this->setData('customer_email', $customerEmail);
    }

    /**
     * @return string
     */
    public function getCustomerEmail(): ?string
    {
        $customerEmail = $this->getData('customer_email');
        return $customerEmail ?? null;
    }

    /**
     * @param bool $allowAddDescription
     */
    public function setAllowAddDescription(bool $allowAddDescription): void
    {
        $this->setData('allow_add_description', $allowAddDescription);
    }

    /**
     * @return bool
     */
    public function getAllowAddDescription(): ?bool
    {
        return (bool) $this->getData('allow_add_description');
    }

    public function setExtensionAttributes(ExtensionAttributesInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }
}

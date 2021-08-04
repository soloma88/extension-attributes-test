<?php

namespace MageCustom\Customer\Api\Data;

interface AllowAddDescriptionInterface
{
    /**
     * @return void
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getId();

    /**
     * @param $customerEmail
     * @return void
     */
    public function setCustomerEmail($customerEmail): void;

    /**
     * @return string
     */
    public function getCustomerEmail(): ?string;

    /**
     * @param bool $allowAddDescription
     * @return void
     */
    public function setAllowAddDescription(bool $allowAddDescription): void;

    /**
     * @return bool
     */
    public function getAllowAddDescription(): ?bool;
}

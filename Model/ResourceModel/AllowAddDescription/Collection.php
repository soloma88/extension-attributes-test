<?php
/**
 * Copyright (c) Rmg Media, LLC. All rights reserved.
 */

declare(strict_types=1);


namespace MageCustom\Customer\Model\ResourceModel\AllowAddDescription;

use MageCustom\Customer\Model\AllowAddDescription as AllowAddDescriptionModel;
use MageCustom\Customer\Model\ResourceModel\AllowAddDescription as AllowAddDescriptionResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(AllowAddDescriptionModel::class, AllowAddDescriptionResourceModel::class);
    }
}

<?php

declare(strict_types=1);

namespace MageCustom\Customer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AllowAddDescription extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_allow_add_description', 'customer_email');
    }
}

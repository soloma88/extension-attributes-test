<?php
declare(strict_types=1);

namespace MageCustom\Customer\Ui\Component;

use Magento\Customer\Ui\Component\DataProvider as DefaultDataProvider;

class DataProvider extends DefaultDataProvider
{
    public function getData()
    {
        //@TODO populate data with extension attributes
        return parent::getData();
    }
}

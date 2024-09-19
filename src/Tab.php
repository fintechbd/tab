<?php

namespace Fintech\Tab;

use Fintech\Tab\Services\AssignVendorService;
use Fintech\Tab\Services\PayBillService;

class Tab
{
    public function payBill($filters = null)
    {
        return \singleton(PayBillService::class, $filters);
    }

    public function assignVendor()
    {
        return \app(AssignVendorService::class);
    }

    //** Crud Service Method Point Do not Remove **//

}

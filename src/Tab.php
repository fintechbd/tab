<?php

namespace Fintech\Tab;

use Fintech\Tab\Services\AssignVendorService;
use Fintech\Tab\Services\PayBillService;

class Tab
{
    public function payBill()
    {
        return app(PayBillService::class);
    }

    public function assignVendor()
    {
        return app(AssignVendorService::class);
    }

    //** Crud Service Method Point Do not Remove **//

}

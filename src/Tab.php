<?php

namespace Fintech\Tab;

use Fintech\Tab\Services\AssignVendorService;
use Fintech\Tab\Services\PayBillService;

class Tab
{
    public function payBill(): PayBillService
    {
        return app(PayBillService::class);
    }

    public function assignVendor(): AssignVendorService
    {
        return app(AssignVendorService::class);
    }

    //** Crud Service Method Point Do not Remove **//

}

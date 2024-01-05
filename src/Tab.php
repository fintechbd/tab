<?php

namespace Fintech\Tab;

use Fintech\Tab\Services\PayBillService;

class Tab
{
    /**
     * @return PayBillService
     */
    public function payBill(): PayBillService
    {
        return app(PayBillService::class);
    }

    //** Crud Service Method Point Do not Remove **//

}

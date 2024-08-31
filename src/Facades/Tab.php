<?php

namespace Fintech\Tab\Facades;

use Fintech\Tab\Services\AssignVendorService;
use Fintech\Tab\Services\PayBillService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PayBillService payBill()
 * @method static AssignVendorService assignVendor()
 *                                                   // Crud Service Method Point Do not Remove //
 *
 * @see \Fintech\Tab\Tab
 */
class Tab extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Fintech\Tab\Tab::class;
    }
}

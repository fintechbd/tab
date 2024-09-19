<?php

namespace Fintech\Tab\Facades;

use Fintech\Tab\Services\AssignVendorService;
use Fintech\Tab\Services\PayBillService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Support\Collection|PayBillService payBill(array $filters = null)
 * @method static \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Support\Collection|AssignVendorService assignVendor(array $filters = null)
 *                                                                                                                                                  // Crud Service Method Point Do not Remove //
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

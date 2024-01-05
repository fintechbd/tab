<?php

namespace Fintech\Tab\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Fintech\Tab\Services\PayBillService payBill()
 * // Crud Service Method Point Do not Remove //
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

<?php

namespace Fintech\Tab\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * // Crud Service Method Point Do not Remove //
 *
 * @see \Fintech\Tab\Tab
 */
class Tab extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fintech\Tab\Tab::class;
    }
}

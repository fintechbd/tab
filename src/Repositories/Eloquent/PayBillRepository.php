<?php

namespace Fintech\Tab\Repositories\Eloquent;

use Fintech\Tab\Interfaces\PayBillRepository as InterfacesPayBillRepository;
use Fintech\Tab\Models\PayBill;
use Fintech\Transaction\Repositories\Eloquent\OrderRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PayBillRepository
 */
class PayBillRepository extends OrderRepository implements InterfacesPayBillRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.tab.pay_bill_model', PayBill::class));
    }

    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @return Paginator|Collection
     *
     * @throws BindingResolutionException
     */
    public function list(array $filters = [])
    {
        return parent::list($filters);

    }
}

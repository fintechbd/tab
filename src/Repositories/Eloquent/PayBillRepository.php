<?php

namespace Fintech\Tab\Repositories\Eloquent;

use Fintech\Tab\Interfaces\PayBillRepository as InterfacesPayBillRepository;
use Fintech\Tab\Models\PayBill;
use Fintech\Transaction\Repositories\Eloquent\OrderRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * Class PayBillRepository
 */
class PayBillRepository extends OrderRepository implements InterfacesPayBillRepository
{
    public function __construct()
    {
        $model = app(config('fintech.tab.pay_bill_model', PayBill::class));

        if (!$model instanceof Model) {
            throw new InvalidArgumentException("Eloquent repository require model class to be `Illuminate\Database\Eloquent\Model` instance.");
        }

        $this->model = $model;
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

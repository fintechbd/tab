<?php

namespace Fintech\Tab\Models;

use Fintech\Airtime\Traits\AuthRelations;
use Fintech\Airtime\Traits\BusinessRelations;
use Fintech\Airtime\Traits\MetaDataRelations;
use Fintech\Core\Traits\AuditableTrait;
use Fintech\Transaction\Models\Order;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayBill extends Order
{
    use AuditableTrait;
    use AuthRelations;
    use BusinessRelations;
    use MetaDataRelations;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = ['order_data' => 'array', 'restored_at' => 'datetime'];

    protected $hidden = ['creator_id', 'editor_id', 'destroyer_id', 'restorer_id'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function currentStatus(): mixed
    {
        return $this->status;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * @return array
     */
    public function getLinksAttribute()
    {
        $primaryKey = $this->getKey();

        $links = [
            'show' => action_link(route('tab.pay-bills.show', $primaryKey), __('restapi::messages.action.show'), 'get'),
            'update' => action_link(route('tab.pay-bills.update', $primaryKey), __('restapi::messages.action.update'), 'put'),
            'destroy' => action_link(route('tab.pay-bills.destroy', $primaryKey), __('restapi::messages.action.destroy'), 'delete'),
            'restore' => action_link(route('tab.pay-bills.restore', $primaryKey), __('restapi::messages.action.restore'), 'post'),
        ];

        if ($this->getAttribute('deleted_at') == null) {
            unset($links['restore']);
        } else {
            unset($links['destroy']);
        }

        return $links;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

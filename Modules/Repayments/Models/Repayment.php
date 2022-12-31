<?php

namespace Modules\Repayments\Models;

use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Repayment extends Authenticatable
{
    use Filterable;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\Repayments\ModelFilters\RepaymentFilter::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_amount_paid',
        //'excess_amount_paid',
        'payment_date',
        'loan_id',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}

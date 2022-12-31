<?php

namespace Modules\Loans\Models;

use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ScheduledLoanRepayments extends Authenticatable
{
    use Filterable;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public function modelFilter()
    {
       // return $this->provideFilter(\Modules\Loans\ModelFilters\LoanFilter::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'payment_date'
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

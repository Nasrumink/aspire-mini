<?php

namespace Modules\Loans\Models;

use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Loan extends Authenticatable
{
    use Filterable;

    public function modelFilter()
    {
        return $this->provideFilter(\Modules\Loans\ModelFilters\LoanFilter::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}

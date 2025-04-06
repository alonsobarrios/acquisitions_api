<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Acquisition extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'budget',
        'unit',
        'type',
        'quantity',
        'unit_value',
        'date',
        'supplier',
        'documentation',
        'status'
    ];

    protected $auditInclude = [
        'budget',
        'unit',
        'type',
        'quantity',
        'unit_value',
        'date',
        'supplier',
        'documentation',
        'status'
    ];

    /**
     * @param Builder $builder
     * @param $search
     * @return Builder
     */
    public function scopeSearch(Builder $builder, $search)
    {
        foreach ($search as $column => $value) {
            switch ($column) {
                case 'unit':
                    if ($value) {
                        $builder->where('unit', 'LIKE', "%{$value}%");
                    }
                    break;
                case 'type':
                    if ($value) {
                        $builder->where('type', 'LIKE', "%{$value}%");
                    }
                    break;
                case 'init_date':
                    if ($value) {
                        $builder->where('date', ">=", $value);
                    }
                    break;
                case 'end_date':
                    if ($value) {
                        $builder->where('date', "<=", $value);
                    }
                    break;
                case 'supplier':
                    if ($value) {
                        $builder->where('supplier', 'LIKE', "%{$value}%");
                    }
                    break;
                case 'status':
                    if ($value === "0" || $value === "1") {
                        $builder->where('status', $value);
                    }
                    break;
            }
        }
        
        return $builder->orderBy('id', 'ASC');
    }
}

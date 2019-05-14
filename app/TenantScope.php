<?php


namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class TenantScope implements Scope
{
    private $tenantId;

    public function __construct($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    public function apply(Builder $builder, Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'tenant_id')) {
            $builder->where('tenant_id', $this->tenantId);
        }
    }
}
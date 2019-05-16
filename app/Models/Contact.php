<?php

namespace App\Models;

use App\HasIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasIdentifier, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

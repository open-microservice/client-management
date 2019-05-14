<?php

namespace App\Models;

use App\HasIdentifier;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasIdentifier;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

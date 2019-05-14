<?php

namespace App\Models;

use App\HasIdentifier;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasIdentifier;

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}

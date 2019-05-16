<?php


namespace App\Http\Requests;


use Illuminate\Database\Eloquent\Model;

interface Persistable
{
    /**
     * Persist the form request
     *
     * @return mixed
     */
    public function persist(Model $record = null);
}
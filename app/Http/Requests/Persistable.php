<?php


namespace App\Http\Requests;


interface Persistable
{
    /**
     * Persist the form request
     *
     * @return mixed
     */
    public function persist();
}
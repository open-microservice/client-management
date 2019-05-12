<?php

namespace App;

use Ramsey\Uuid\Uuid;

trait HasIdentifier
{
    /**
     * Add the event listener for saving a Uuid when the
     * model is created
     *
     * @return void
     */
    public static function bootHasIdentifier()
    {
        static::creating(
            function ($model) {
                $model->identifier = Uuid::uuid4()->toString();
            }
        );
    }

    /**
     * Set the key to 'identifier' for route model
     * binding
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }
}
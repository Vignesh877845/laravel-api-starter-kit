<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait HasUuidPrimaryKey
{
    use HasUuids;

    public function initializeHasUuidPrimaryKey()
    {
        $this->incrementing = false;
        $this->keyType = 'string';
    }
}

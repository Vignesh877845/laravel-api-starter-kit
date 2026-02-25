<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait HasDynamicPrimaryKey
{
    use HasUuids;

    /**
     * Boot the trait and set the key type based on configuration.
     * This ensures the model respects the 'use_uuid' feature toggle.
     */
    public function initializeHasDynamicPrimaryKey()
    {
        if (config('features.use_uuid')) {
            $this->incrementing = false;
            $this->keyType = 'string';
        } else {
            $this->incrementing = true;
            $this->keyType = 'int';
        }
    }

    /**
     * Determine if the model should generate unique IDs.
     */
    public function uniqueIds()
    {
        return config('features.use_uuid') ? [$this->getKeyName()] : [];
    }
}

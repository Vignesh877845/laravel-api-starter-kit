<?php

namespace App\Models;

use App\Traits\HasDynamicPrimaryKey;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasDynamicPrimaryKey;
}

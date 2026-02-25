<?php

namespace App\Models;

use App\Traits\HasDynamicPrimaryKey;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasDynamicPrimaryKey;
}

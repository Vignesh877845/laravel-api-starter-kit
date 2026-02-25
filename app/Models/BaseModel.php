<?php

namespace App\Models;

use App\Traits\HasDynamicPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasDynamicPrimaryKey;
}

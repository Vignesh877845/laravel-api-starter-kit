<?php

namespace App\Models;

use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasUuidPrimaryKey;
}

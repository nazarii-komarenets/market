<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    public $table = 'users';
}

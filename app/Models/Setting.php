<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    public function system()
    {
        return Setting::where('name', '=', 'system')
                ->get()
                ;
    }
}

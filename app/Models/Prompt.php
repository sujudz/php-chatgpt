<?php

namespace App\Models;

class Prompt extends Model
{
    public function list()
    {
        return Prompt::query();
    }

    public function single($id)
    {
        return Prompt::where('id', '=', $id)
                ->first();
    }
}

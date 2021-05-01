<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function releases()
    {
        # Project has many Release
        # Define a one-to-many relationship.
        return $this->hasMany('App\Models\Release');
    }
}
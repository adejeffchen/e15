<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    public function project()
    {
        # Release belongs to project
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\Models\Project');
    }
}
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

    public function dependencies()
    {
        return $this->belongsToMany(Release::class, 'dependencies', 'release_id', 'dependent_release_id');
    }

    public function blocks()
    {
        return $this->belongsToMany(Release::class, 'dependencies', 'dependent_release_id', 'release_id');
    }

    public function release_date_display()
    {
        $release_date = date_create($this->release_date);

        if ($this->day_confirmed) {
            $release_date_display = date_format($release_date, "M j, Y");
        } else {
            $release_date_display = date_format($release_date, "M, Y") . " (day not confirmed)";
        }

        return $release_date_display;
    }
}
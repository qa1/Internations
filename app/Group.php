<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Show the users related to group
     *
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\Group', 'user_groups');
    }

}

<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='admin_roles';
    public function users()
    {
        return $this->belongsToMany(User::class, 'adminroles');
    }
}

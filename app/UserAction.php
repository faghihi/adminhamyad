<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAction
 *
 * @package App
 * @property string $user
 * @property string $action
 * @property string $action_model
 * @property integer $action_id
 */

class UserAction extends Model
{
//    use SoftDeletes;


    protected $table='user_actions';
    protected $fillable = ['action', 'action_model', 'action_id', 'user_id'];

    /**
     * Set to null if empty
     * @param $input
     */

    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }

    public function user()
    {
        /*
         * soft deleted models will automatically be excluded from query results.
         * However, you may force soft deleted models to appear in a result
         * set using the withTrashed method on the query
         * The withTrashed method may also be used
         * on a relationship query.
         */
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
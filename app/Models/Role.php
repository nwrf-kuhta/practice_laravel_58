<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @var string テーブル名 */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_viewable', 'is_editable',
    ];

    /**
     * usersとのリレーション (1対多)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'role_id');
    }

    /**
     * 閲覧権限があるかを返す
     *
     * @return bool
     */
    public function isViewable(): bool
    {
        if (is_null($this->is_viewable)) {
            return false;
        }

        return ($this->is_viewable === 1);
    }

    /**
     * 編集権限があるかを返す
     *
     * @return bool
     */
    public function isEditable(): bool
    {
        if (is_null($this->is_editable)) {
            return false;
        }

        return ($this->is_editable === 1);
    }
}

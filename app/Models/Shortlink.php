<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shortlink extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'type', 'password', 'valid_from', 'valid_until', 'maxvists', 'active', 'suspended'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'type' => 'string',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'maxvists' => 'integer',
        'active' => 'boolean',
        'suspended' => 'boolean',
    ];


    public function setPasswordAttribute($password = null)
    {
        if ($password) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    /**
     * @return string
     */
    public function getURL()
    {
        $generator = url();

        $generator->forceRootUrl($this->domain->name);

        return $generator->to($this->code);
    }


    /**
     * Get the shortlink domain.
     */
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * Get the visits for the shortlink.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get the shortlink user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the target.
     */
    public function target()
    {
        return $this->morphTo();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'targets';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($target) {
            $target->type = 'Target';
        });
    }

    /**
     * Get all of the targets's shortlinks.
     */
    public function shortlinks()
    {
        return $this->morphMany(Shortlink::class, 'target');
    }
}

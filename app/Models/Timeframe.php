<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeframe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'Start_Date',
        'End_Date',
        'Semester',
    ];

    /**
     * Define a relationship with the Quota model.
     */
    public function quotas()
    {
        return $this->hasMany(Quota::class, 'TimeFrame_ID', 'TimeFrame_ID');
    }
}

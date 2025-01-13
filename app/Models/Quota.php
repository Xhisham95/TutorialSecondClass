<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $table = 'quotas'; // Database table
    protected $primaryKey = 'Quota_ID'; // Primary key
    protected $fillable = ['Supervisor_ID', 'QuotaNumber']; // Fillable attributes

    // Relationship with User (Belongs to a supervisor)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'Supervisor_ID', 'User_ID');
    }
}

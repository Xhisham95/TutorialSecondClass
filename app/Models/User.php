<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users'; // Database table
    protected $primaryKey = 'User_ID'; // Primary key
    protected $fillable = [
        'UserName',
        'Password',
        'Email',
        'Role',
        'Program'
    ]; // Fillable attributes

    protected $hidden = ['Password', 'remember_token']; // Hidden attributes

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship with Quotas (One-to-One)
    public function quota()
    {
        return $this->hasOne(Quota::class, 'Supervisor_ID', 'User_ID');
    }

    // Relationship with Appointments (One-to-Many)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'Student_ID', 'User_ID');
    }

    // Relationship with Project Topics (Student)
    public function projectTopics()
    {
        return $this->hasMany(ProjectTopic::class, 'Student_ID', 'User_ID');
    }

    // Relationship with Project Topics (Supervisor)
    public function supervisedTopics()
    {
        return $this->hasMany(ProjectTopic::class, 'Supervisor_ID', 'User_ID');
    }
}

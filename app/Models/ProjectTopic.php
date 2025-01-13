<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTopic extends Model
{
    protected $table = 'project_topics'; // Database table
    protected $primaryKey = 'Topic_ID'; // Primary key
    protected $fillable = [
        'Student_ID',
        'Supervisor_ID',
        'Topic_Title',
        'Topic_Description',
        'Status'
    ]; // Fillable attributes

    // Relationship with User (Student)
    public function student()
    {
        return $this->belongsTo(User::class, 'Student_ID', 'User_ID');
    }

    // Relationship with User (Supervisor)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'Supervisor_ID', 'User_ID');
    }

    // Relationship with FileUpload (One-to-Many)
    public function fileUploads()
    {
        return $this->hasMany(FileUpload::class, 'Topic_ID', 'Topic_ID');
    }
}

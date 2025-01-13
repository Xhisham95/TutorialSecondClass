<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $table = 'file_uploads'; // Database table
    protected $primaryKey = 'File_ID'; // Primary key
    protected $fillable = [
        'Student_ID',
        'Topic_ID',
        'File_Name',
        'File_Path',
        'Uploaded_At'
    ]; // Fillable attributes

    // Relationship with User (Student)
    public function student()
    {
        return $this->belongsTo(User::class, 'Student_ID', 'User_ID');
    }

    // Relationship with ProjectTopic
    public function projectTopic()
    {
        return $this->belongsTo(ProjectTopic::class, 'Topic_ID', 'Topic_ID');
    }
}

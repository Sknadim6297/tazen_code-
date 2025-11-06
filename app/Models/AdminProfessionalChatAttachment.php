<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminProfessionalChatAttachment extends Model
{
    use HasFactory;

    protected $table = 'admin_professional_chat_attachments';

    protected $fillable = [
        'message_id',
        'original_name',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size'
    ];

    protected $appends = ['file_icon', 'human_file_size'];

    /**
     * Get the message that owns this attachment
     */
    public function message()
    {
        return $this->belongsTo(AdminProfessionalChatMessage::class, 'message_id');
    }

    /**
     * Get the full URL for the attachment
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get human readable file size
     */
    public function getHumanFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is an image
     */
    public function isImage()
    {
        return in_array($this->file_type, ['image']) || 
               in_array($this->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    /**
     * Check if file is a document
     */
    public function isDocument()
    {
        return in_array($this->file_type, ['document']) ||
               in_array($this->mime_type, [
                   'application/pdf',
                   'application/msword',
                   'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                   'application/vnd.ms-excel',
                   'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                   'text/plain'
               ]);
    }

    /**
     * Get file icon based on type
     */
    public function getFileIconAttribute()
    {
        if ($this->isImage()) {
            return 'ri-image-line';
        } elseif ($this->isDocument()) {
            return 'ri-file-text-line';
        } else {
            return 'ri-attachment-line';
        }
    }
}

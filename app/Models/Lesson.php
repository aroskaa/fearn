<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Lesson extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        // 'slug',
        'description',
        'content',
        'video_url',
        'duration',
        'order',
        'course_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the course that owns the lesson.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if the lesson is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if the lesson is a draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function getEmbedVideoUrlAttribute()
    {
        if (empty($this->video_url)) {
            return null;
        }

        // Handle YouTube URLs
        if (str_contains($this->video_url, 'youtube.com') || str_contains($this->video_url, 'youtu.be')) {
            $videoId = null;
            
            // Handle full YouTube URLs
            if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $this->video_url, $matches)) {
                $videoId = $matches[1];
            }
            // Handle shortened youtu.be URLs
            elseif (preg_match('/youtu\.be\/([^?]+)/', $this->video_url, $matches)) {
                $videoId = $matches[1];
            }

            if ($videoId) {
                return "https://www.youtube.com/embed/" . $videoId;
            }
        }

        return $this->video_url;
    }
}

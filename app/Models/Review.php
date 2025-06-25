<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'professor_id',
        'rating',
        'content',
        'helpful_votes',
    ];

    protected $casts = [
        'rating' => 'integer',
        'helpful_votes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Helper method to get average rating
    public static function getAverageRating($courseId = null, $professorId = null)
    {
        $query = self::query();
        
        if ($courseId) {
            $query->where('course_id', $courseId);
        }
        
        if ($professorId) {
            $query->where('professor_id', $professorId);
        }
        
        return $query->avg('rating');
    }

    // Helper method to get rating distribution
    public static function getRatingDistribution($courseId = null, $professorId = null)
    {
        $query = self::query();
        
        if ($courseId) {
            $query->where('course_id', $courseId);
        }
        
        if ($professorId) {
            $query->where('professor_id', $professorId);
        }
        
        return $query->selectRaw('rating, count(*) as count')
                    ->groupBy('rating')
                    ->orderBy('rating')
                    ->pluck('count', 'rating');
    }
}

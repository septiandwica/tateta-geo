<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiUsage extends Model
{
    protected $table = 'api_usage';

    protected $fillable = [
        'user_id',
        'date',
        'endpoint',
        'count',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user that owns the API usage
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Increment usage count for a user, date, and endpoint
     */
    public static function track($userId, $endpoint)
    {
        $today = now()->toDateString();
        
        $usage = self::firstOrCreate(
            [
                'user_id' => $userId,
                'date' => $today,
                'endpoint' => $endpoint,
            ],
            ['count' => 0]
        );
        
        $usage->increment('count');
        
        return $usage;
    }

    /**
     * Get total usage for a user on a specific date
     */
    public static function getTotalForUserOnDate($userId, $date)
    {
        return self::where('user_id', $userId)
            ->where('date', $date)
            ->sum('count');
    }

    /**
     * Get usage for a user in a date range
     */
    public static function getUsageInRange($userId, $startDate, $endDate)
    {
        return self::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('count');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'address',
        'photo',
        'user_id',
        'cache_votes',
        'district'
    ];

    public static function getVisibleReports($search = '')
    {
        return Report::query()
            ->where('address', 'like', $search)
            ->where('cache_votes', '>', -10)
            ->with('user')
            ->paginate();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

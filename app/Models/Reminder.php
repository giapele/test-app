<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['name', 'event_id'];

    public function events()
    {
        return $this->belongsTo(Event::class);
    }
}

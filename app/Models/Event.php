<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'start'];
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['agency_id', 'position_id', 'name', 'nip', 'email'];

    public function agency()
    {
        return $this->belongsTo(Agency::class)->withDefault();
    }

    public function position()
    {
        return $this->belongsTo(Position::class)->withDefault();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nip')->withDefault();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'type', 'checkin_longitude', 'checkin_latitude', 'checkout_longitude', 'checkout_latitude', 'checkin_time', 'checkout_time', 'checkin_photo', 'checkout_photo'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault();
    }

    public function type()
    {
        if ($this->type == 1) {
            return 'Reguler';
        } else {
            return 'Penugasan';
        }
    }

    public function status()
    {
        if ($this->checkin_time > '09:00:00') {
            return 'Terlambat';
        } else {
            return 'Tepat Waktu';
        }
    }

    public function scopeCheckAttendance($query, $value)
    {
        return $query->whereDate('created_at', \Carbon\Carbon::today())
            ->where('employee_id', auth()->user()->username)
            ->where('type', $value);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'type', 'explanation', 'file', 'start_date', 'end_date', 'status'];

    public function type()
    {
        if ($this->type == 1) {
            return 'Izin';
        } elseif ($this->type == 2) {
            return 'Cuti';
        } else {
            return 'Sakit';
        }
    }

    public function status()
    {
        if ($this->status == 1) {
            return 'Disetujui';
        } elseif ($this->status == 2) {
            return 'Belum disetujui';
        } else {
            return 'Ditolak';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault();
    }
}

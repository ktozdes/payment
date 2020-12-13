<?php

namespace App\Models;

use App\Events\PaymentCreated;
use App\Events\PaymentUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'phone', 'token', 'email', 'payed_at', 'card_id'];
    protected $dates = ['payed_at'];

    protected $dispatchesEvents = [
        'created' => PaymentCreated::class,
        'updated' => PaymentUpdated::class
    ];

    public function histories()
    {
        return $this->hasMany(PaymentHistory::class);
    }
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
    public function getcurrentStatusAttribute()
    {
        $lastHistory = $this->histories()->orderBy('created_at', 'desc')->first();
        return isset($lastHistory) ? $lastHistory->status : null;
    }
    public function getCurrencyAttribute()
    {
        if (is_numeric($this->amount)) {
            return number_format($this->amount, 2) . ' KZT';
        }
        return $this->amount;
    }
}

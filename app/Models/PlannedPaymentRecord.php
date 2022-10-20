<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlannedPaymentRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'planned_payment_id',
        'wallet_id',
        'to_wallet_id',
        'record_id',
        'to_record_id',
        'period',
        'type',
        'amount',
        'extra_type',
        'extra_percentage',
        'extra_amount',
        'status',
        'confirmed_at',
        'timezone_offset',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 
    ];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Primary Key Relation
     * 
     * @return model
     */

    /**
     * Foreign Key Relation
     * 
     * @return model
     */
    public function plannedPayment()
    {
        return $this->belongsTo(\App\Models\PlannedPayment::class, 'planned_payment_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function wallet()
    {
        return $this->belongsTo(\App\Models\Wallet::class, 'wallet_id')
            ->withTrashed();
    }
    public function walletTransferTarget()
    {
        return $this->belongsTo(\App\Models\Wallet::class, 'to_wallet_id')
            ->withTrashed();
    }
    public function record()
    {
        return $this->belongsTo(\App\Models\Record::class, 'record_id');
    }
    public function recordTransferTarget()
    {
        return $this->belongsTo(\App\Models\Record::class, 'to_record_id');
    }

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Listen to Create Event
        static::creating(function ($model) {
            // Always generate UUID on Data Create
            $model->{'uuid'} = (string) Str::uuid();
        });

        // Listen to updated Event
        static::updating(function ($model) {
            if ($model->getOriginal('status') === 'pending' && $model->status !== 'pending') {
                // Set Current date to first date of each month
                $raw_date = date('Y-m-01', strtotime($model->period));
                /**
                 * Calculate Next Period
                 */
                // Get Repetition Type
                $repeat_type = $model->plannedPayment->getRepeatType($model->plannedPayment->repeat_type);
                // Get Time Added
                $timeadded = ' +'.$model->plannedPayment->repeat_every.' '.$repeat_type;
                $next_period = date('Y-m-d', strtotime($raw_date.$timeadded));

                /**
                 * Calculate Final Date
                 */
                $day = date('d', strtotime($model->plannedPayment->start_date));
                $lastDayOfNextPeriod = date('t', strtotime($next_period));
                if ($day > $lastDayOfNextPeriod) {
                    $next_period = date('Y-m-t', strtotime($next_period));
                } else {
                    $next_period = date('Y-m', strtotime($next_period)).'-'.$day;
                }

                // Create next Planned Payment Record
                $planned_record = new \App\Models\PlannedPaymentRecord([
                    'user_id' => $model->user_id,
                    'planned_payment_id' => $model->plannedPayment->id,
                    'wallet_id' => $model->plannedPayment->wallet_id,
                    'to_wallet_id' => $model->plannedPayment->to_wallet_id,
                    'record_id' => null,
                    'to_record_id' => null,
                    'period' => date('Y-m-d', strtotime($next_period)),
                    'type' => $model->plannedPayment->type,
                    'amount' => $model->plannedPayment->amount,
                    'extra_type' => $model->plannedPayment->extra_type,
                    'extra_percentage' => $model->plannedPayment->extra_percentage,
                    'extra_amount' => $model->plannedPayment->extra_type === 'percentage' ? $model->plannedPayment->amount * ($model->plannedPayment->extra_percentage / 100) : $model->plannedPayment->extra_amount,
                    'status' => 'pending',
                    'confirmed_at' => null,
                ]);
                $planned_record->save();

                // Update Next  Periode
                $plannedPayment = $model->plannedPayment;
                $plannedPayment->next_date = date('Y-m-d', strtotime($next_period));
                $plannedPayment->save();
            }
        });
    }
}

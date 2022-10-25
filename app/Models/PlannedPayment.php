<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlannedPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'type',
        'wallet_id',
        'to_wallet_id',
        'amount',
        'extra_type',
        'extra_percentage',
        'extra_amount',
        'start_date',
        'next_date',
        'repeat_type',
        'repeat_every',
        'until_type',
        'until_number',
        'note',
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
    public function record()
    {
        return $this->hasMany(\App\Models\Record::class, 'planned_id');
    }
    public function plannedPaymentRecord()
    {
        return $this->hasMany(\App\Models\PlannedPaymentRecord::class, 'planned_payment_id');
    }

    /**
     * Foreign Key Relation
     * 
     * @return model
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
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

    /**
     * Laravel Scope
     */
    public function scopeGetRepeatType($query, $repeat_type = null)
    {
        if (empty($repeat_type)) {
            $repeat_type = $this->repeat_type;
        }
        // Get Repetition Type
        switch ($repeat_type) {
            case 'yearly':
                $repeat_type = 'year';
                break;
            case 'monthly':
                $repeat_type = 'month';
                break;
            case 'weekly':
                $repeat_type = 'week';
                break;
            default:
                $repeat_type = 'day';
                break;
        }

        return $repeat_type;
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

        // Listen to Created Event
        static::created(function ($model) {
            // Create Planned Payment Record
            $planned_record = new \App\Models\PlannedPaymentRecord([
                'user_id' => $model->user_id,
                'planned_payment_id' => $model->id,
                'wallet_id' => $model->wallet_id,
                'to_wallet_id' => $model->to_wallet_id,
                'record_id' => null,
                'to_record_id' => null,
                'period' => date('Y-m-d', strtotime($model->start_date)),
                'type' => $model->type,
                'amount' => $model->amount,
                'extra_type' => $model->extra_type,
                'extra_percentage' => $model->extra_percentage,
                'extra_amount' => $model->extra_amount,
                'status' => 'pending',
                'confirmed_at' => null,
            ]);
            $planned_record->save();
        });
        // Listen to Updating Event
        static::updating(function ($model) {
            // Get Latest Pending Planned Payment Record
            $pendingRecord = \App\Models\PlannedPaymentRecord::where('planned_payment_id', $model->id)
                ->where('status', 'pending')
                ->orderBy('id', 'desc')
                ->first();
            if (!empty($pendingRecord)) {
                if($model->getOriginal('start_date') !== $model->start_date){
                    // Update date
                    if ($model->start_date >= $pendingRecord->period) {
                        $model->next_date = $model->start_date;
    
                        // Update period
                        $pendingRecord->period = $model->start_date;
                    }
                }

                $pendingRecord->wallet_id = $model->wallet_id;
                $pendingRecord->to_wallet_id = $model->to_wallet_id;
                $pendingRecord->type = $model->type;
                $pendingRecord->amount = $model->amount;
                $pendingRecord->extra_type = $model->extra_type;
                $pendingRecord->extra_percentage = $model->extra_percentage;
                $pendingRecord->extra_amount = $model->extra_amount;
                $pendingRecord->save();
            }
        });
        // Listen to saving Event
        static::saving(function ($model) {
            if ($model->extra_type === null) {
                $model->extra_type = 'amount';
            }
            if ($model->extra_amount === 'percentage') {
                if ($model->extra_percentage === null) {
                    $model->extra_percentage = 0;
                }
            }
        });
    }
}

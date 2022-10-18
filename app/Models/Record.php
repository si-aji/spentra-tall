<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Record extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'planned_id',
        'user_id',
        'category_id',
        'type',
        'wallet_id',
        'to_wallet_id',
        'amount',
        'extra_type',
        'extra_percentage',
        'extra_amount',
        'date',
        'time',
        'datetime',
        'note',
        'status',
        'receipt',
        'timezone_offset',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'id',
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
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
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
            // Update planned id next payment
            
        });
        // Listen to Saving Event
        static::saving(function ($model) {
            if ($model->extra_amount === null) {
                $model->extra_amount = 0;
            }
            if ($model->extra_type === null) {
                $model->extra_type = 'amount';
            }

            if ($model->extra_amount === 'percentage') {
                if ($model->extra_percentage === null) {
                    $model->extra_percentage = 0;
                }

                $calc = ($model->amount * $model->extra_percentage) / 100;
                if ($calc !== $model->extra_amount) {
                    // Add default extra amount, based on percentage value
                    $model->extra_amount = $calc;
                }
            }

            if (empty($model->timezone_offset)) {
                $model->timezone_offset = env('APP_TIMEZONE_OFFSET');
            }
        });
    }

    /**
     * Accessor
     *
     * Laravel Getter
     */
    public function getExtraAmountAttribute($value)
    {
        return ! empty($value) ? $value : 0;
    }

    /**
     * Mutator
     *
     * Laravel Setter
     */
    public function setExtraAmountAttribute($value)
    {
        $this->attributes['extra_amount'] = ! empty($value) ? $value : 0;
    }

    /**
     * Scope
     * 
     */
    public function scopeGetRelatedTransferRecord()
    {
        $related = [];
        if(!empty($this->to_wallet_id)){
            $related = $this->where('user_id', $this->user_id)
                ->where('id', '!=', $this->id)
                ->where('receipt', $this->receipt)
                ->where('amount', $this->amount);

            if($this->type === 'expense'){
                // Get related income
                $related->where('type', 'income')
                    ->where('wallet_id', $this->to_wallet_id);
            } else {
                // Get related expense
                $related->where('type', 'expense')
                    ->where('wallet_id', $this->to_wallet_id);
            }

            $related = $related->first()->load('wallet.parent', 'walletTransferTarget.parent', 'category.parent');
        }

        return $related;
    }
}

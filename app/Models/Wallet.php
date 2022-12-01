<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'type',
        'order',
        'order_main',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
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
    public function child()
    {
        return $this->hasMany(\App\Models\Wallet::class, 'parent_id')
            ->withTrashed();
    }
    public function record()
    {
        return $this->hasMany(\App\Models\Record::class, 'wallet_id');
    }
    public function recordTransferTarget()
    {
        return $this->hasMany(\App\Models\Record::class, 'to_wallet_id');
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
    public function parent()
    {
        return $this->belongsTo(\App\Models\Wallet::class, 'parent_id')
            ->withTrashed();
    }
    public function walletGroup()
    {
        return $this->belongsToMany(\App\Models\WalletGroup::class, (new \App\Models\WalletGroupList())->getTable())
            ->using(\App\Models\WalletGroupList::class)
            ->withTimestamps();
    }
    public function walletShare()
    {
        return $this->belongsToMany(\App\Models\WalletShare::class, (new \App\Models\WalletShareDetail())->getTable())
            ->using(\App\Models\WalletShareDetail::class)
            ->withTimestamps();
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
    }

    /**
     * Laravel Scope
     * 
     */
    public function scopeGetBalance($query, $period = null)
    {
        $balance = $this->record()
            // ->select(\DB::raw('IFNULL(SUM((amount + extra_amount) * IF(type = "expense", -1, 1)), 0) as balance'))
            // ->where('wallet_id', $this->id)
            ->where('status', 'complete');

        if (! empty($period) && validateDate($period, 'Y-m-d H:i:s')) {
            $balance->where('datetime', '<', $period);
        }

        $balance->orderBy('datetime', 'desc')
            ->orderBy('created_at', 'desc');

        return $balance->sum(\DB::raw('(amount + extra_amount) * IF(type = "expense", -1, 1)'));
    }
    public function scopeGetLastTransaction($query)
    {
        return $this->record()->where('status', 'complete')->orderBy('datetime', 'desc')->first() ?? [];
    }
}

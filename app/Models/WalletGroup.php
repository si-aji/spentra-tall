<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WalletGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
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
    public function walletGroupList()
    {
        return $this->belongsToMany(\App\Models\Wallet::class, (new \App\Models\WalletGroupList())->getTable())
            ->using(\App\Models\WalletGroupList::class)
            ->withTimestamps()
            ->withTrashed();
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
     * Scope
     *
     * Run specific function
     */
    public function scopeGetBalance($query, $walletList = null, $period = null, $type = 'all')
    {
        if (empty($walletList)) {
            $walletList = $this->walletGroupList()
                ->withoutTrashed()
                ->pluck('wallet_id');
        } else if($walletList === 'all' && \Auth::check()){
            $walletList = \App\Models\Wallet::where('user_id', \Auth::user()->id)
                ->pluck('id');
        }

        $record = new \App\Models\Record();
        $balance = \DB::table($record->getTable())
            ->select(\DB::raw('IFNULL(SUM((amount + extra_amount) * IF(type = "expense", -1, 1)), 0) as balance'))
            ->whereIn('wallet_id', $walletList)
            ->where('status', 'complete');

        if (!empty($period)){
            if(is_array($period)){
                $start = $period[0];
                $end = $period[1];

                if(validateDate($start, 'Y-m-d') && validateDate($end, 'Y-m-d')){
                    $balance->whereBetween('date', [$start, $end]);
                } else if(validateDate($start, 'Y-m-d H:i:s') && validateDate($end, 'Y-m-d H:i:s')){
                    $balance->whereBetween('datetime', [$start, $end]);
                }
            } else if(validateDate($period, 'Y-m-d')) {
                $balance->where('date', '<', $period);
            } else if(validateDate($period, 'Y-m-d H:i:s')) {
                $balance->where('datetime', '<', $period);
            }
        }
        if(!empty($type) && $type !== 'all'){
            $balance->where('type', $type);
        }

        $balance->orderBy('datetime', 'desc')
            ->orderBy('created_at', 'desc');

        return $balance->sum(\DB::raw('(amount + extra_amount) * IF(type = "expense", -1, 1)'));
    }
    public function scopeGetBalanceByType($query, $type = 'income', $walletList = null, $period = null)
    {
        return $this->getBalance($walletList, $period, $type);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// Webpush
use NotificationChannels\WebPush\HasPushSubscriptions as HasPushSubscriptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Primary Key Relation
     *
     * @return model
     */
    public function category()
    {
        return $this->hasMany(\App\Models\Category::class, 'user_id');
    }
    public function wallet()
    {
        return $this->hasMany(\App\Models\Wallet::class, 'user_id')
            ->withTrashed();
    }
    public function walletGroup()
    {
        return $this->hasMany(\App\Models\WalletGroup::class, 'user_id');
    }
    public function walletShare()
    {
        return $this->hasMany(\App\Models\WalletShare::class, 'user_id');
    }
    public function record()
    {
        return $this->hasMany(\App\Models\Record::class, 'user_id');
    }
    public function recordTemplate()
    {
        return $this->hasMany(\App\Models\RecordTemplate::class, 'user_id');
    }
    public function plannedPayment()
    {
        return $this->hasMany(\App\Models\PlannedPayment::class, 'user_id');
    }
    public function shoppingList()
    {
        return $this->hasMany(\App\Models\ShoppingList::class, 'user_id');
    }
    public function userPreference()
    {
        return $this->hasMany(\App\Models\UserPreference::class, 'user_id');
    }
    public function recordReminderLog()
    {
        return $this->hasMany(\App\Models\RecordReminderLog::class, 'user_id');
    }

    /**
     * Foreign Key Relation
     *
     * @return model
     */
    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id');
    }

    /**
     * Scope
     * 
     */
    public function scopeGetProfilePicture()
    {
        $asset = 'assets/img/no-pict.jpeg';
        return asset(!empty($this->avatar) ? $this->avatar : $asset);
    }
    public function scopeGetFirstYearRecord()
    {
        $firstYear = 2020;
        // $record = \App\Models\Record::where('user_id', $this->id)
        //     ->orderBy('date', 'asc')
        //     ->first();
        // if (! empty($record)) {
        //     $firstYear = date('Y', strtotime($record->date));
        // }

        return $firstYear;
    }
    public function scopeGetSpecificUserPreference($query, $key = null)
    {
        $data = null;
        if(!empty($key)){
            $data = $this->userPreference()->where('key', $key)->first();
        }

        return $data;
    }
}

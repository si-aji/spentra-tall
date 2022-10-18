<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    /**
     * Foreign Key Relation
     *
     * @return model
     */

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
}

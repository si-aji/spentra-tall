<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecordTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'wallet_id',
        'to_wallet_id',
        'amount',
        'extra_type',
        'extra_percentage',
        'extra_amount',
        'note',
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
    public function recordTemplateTags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'record_template_tags', 'record_template_id', 'tag_id')
            ->using(\App\Models\RecordTemplateTag::class)
            ->orderBy('name', 'asc')
            ->withTimestamps();
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
                    $model->extra_amount = $calc;
                }
            }
        });
    }
}

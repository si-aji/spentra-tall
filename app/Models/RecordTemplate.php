<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\RecordTemplate
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property string $name
 * @property int|null $category_id
 * @property string $type
 * @property int $wallet_id
 * @property int|null $to_wallet_id
 * @property float $amount
 * @property string $extra_type
 * @property float|null $extra_percentage
 * @property float|null $extra_amount
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $recordTemplateTags
 * @property-read int|null $record_template_tags_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Wallet $wallet
 * @property-read \App\Models\Wallet|null $walletTransferTarget
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereExtraAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereExtraPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereExtraType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereToWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecordTemplate whereWalletId($value)
 * @mixin \Eloquent
 */
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

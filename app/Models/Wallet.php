<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $name
 * @property int|null $order
 * @property int|null $order_main
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $budget
 * @property-read int|null $budget_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Wallet[] $child
 * @property-read int|null $child_count
 * @property-read Wallet|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlannedPayment[] $plannedPayment
 * @property-read int|null $planned_payment_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlannedPaymentRecord[] $plannedPaymentRecord
 * @property-read int|null $planned_payment_record_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlannedPaymentRecord[] $plannedPaymentRecordTransferTarget
 * @property-read int|null $planned_payment_record_transfer_target_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PlannedPayment[] $plannedPaymentTransferTarget
 * @property-read int|null $planned_payment_transfer_target_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Record[] $record
 * @property-read int|null $record_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecordTemplate[] $recordTemplate
 * @property-read int|null $record_template_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecordTemplate[] $recordTemplateTransferTarget
 * @property-read int|null $record_template_transfer_target_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Record[] $recordTransferTarget
 * @property-read int|null $record_transfer_target_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WalletGroup[] $walletGroup
 * @property-read int|null $wallet_group_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WalletShareDetail[] $walletShareDetail
 * @property-read int|null $wallet_share_detail_count
 *
 * @method static \Database\Factories\WalletFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet getBalance($recordId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Query\Builder|Wallet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereOrderMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallet withoutTrashed()
 * @mixin \Eloquent
 *
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Budget[] $budgetExclude
 * @property-read int|null $budget_exclude_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereType($value)
 */
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
}

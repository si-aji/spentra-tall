<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
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
    public function recordTags()
    {
        return $this->belongsToMany(\App\Models\Record::class, 'record_tags', 'tag_id', 'record_id')
            ->using(\App\Models\RecordTag::class);
    }
    public function recordTemplateTags()
    {
        return $this->belongsToMany(\App\Models\User::class, 'record_template_tags', 'tag_id', 'record_template_id')
            ->using(\App\Models\RecordTemplateTag::class);
    }
    public function plannedPaymentTags()
    {
        return $this->belongsToMany(\App\Models\PlannedPayment::class, 'planned_payment_tags', 'planned_payment_id', 'tag_id')
            ->using(\App\Models\PlannedPaymentTag::class);
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
}

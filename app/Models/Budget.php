<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Budget extends Model
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
        'amount',
        'period_type',
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
    public function budgetTag()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'budget_tags', 'budget_id', 'tag_id')
            ->using(\App\Models\BudgetTag::class)
            ->orderBy('name', 'asc')
            ->withTimestamps();
    }
    public function budgetWallet()
    {
        return $this->belongsToMany(\App\Models\Wallet::class, 'budget_wallets', 'budget_id', 'wallet_id')
            ->using(\App\Models\BudgetWallet::class)
            ->orderBy('order_main', 'asc')
            ->withTimestamps();
    }
    public function budgetCategory()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'budget_categories', 'budget_id', 'category_id')
            ->using(\App\Models\BudgetCategory::class)
            ->orderBy('order_main', 'asc')
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

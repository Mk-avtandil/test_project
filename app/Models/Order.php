<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasPosition, HasFactory;

    const STATUSES = ['pending', 'completed'];

    protected $fillable = [
        'user_id',
        'status',
        'published',
        'position',
    ];

    public $slugAttributes = [
        'title',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderables() : HasMany
    {
        return $this->hasMany(Orderable::class);
    }

//    protected static function booted(): void
//    {
//        static::created(function ($order) {
//            event(new OrderPlaced($order));
//        });
//
//        static::updated(function ($order) {
//            event(new OrderPlaced($order));
//        });
//    }

    public function scopeProductsOnly($query): Builder
    {
        return $query->where('orderable_type', 'App\\Models\\Product');
    }
    public function scopeServicesOnly($query): Builder
    {
        return $query->where('orderable_type', 'App\\Models\\Service');
    }

    public function scopeCompleted($query) {
        return $query->where('status', 'completed');
    }

    public function scopePending($query) {
        return $query->where('status', 'pending');
    }
}

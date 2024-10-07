<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasNesting;
use A17\Twill\Models\Behaviors\Sortable;
use App\Listeners\UpdateServiceCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use A17\Twill\Models\Model;

class Service extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, HasNesting, HasFactory;

    protected $fillable = [
        'published',
        'position',
        'type',
        'price',
        'deadline',
        'example_link'
    ];

    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($service) {
            (new UpdateServiceCache())->handle($service);
        });
    }
}

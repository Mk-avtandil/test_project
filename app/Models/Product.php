<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Listeners\UpdateProductCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Product extends Model implements Sortable
{
    use HasBlocks, HasMedias, HasFiles, HasRevisions, HasPosition, HasFactory, HandleRevisions;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'size',
        'type',
        'color',
        'quantity',
        'price'
    ];

    public function orders() : MorphMany {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($product) {
            (new UpdateProductCache())->handle($product);
        });

        static::updated(function ($product) {
            (new UpdateProductCache())->handle($product);
        });

        static::deleted(function ($product) {
            $product->orders()->delete();
            $product->comments()->delete();

            (new UpdateProductCache())->handle($product);
        });
    }

    public $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
        ],
    ];
}

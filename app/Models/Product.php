<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use App\Listeners\UpdateProductCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class Product extends Model implements Sortable
{
    use HasBlocks, HasMedias, HasFiles, HasRevisions, HasPosition, HasFactory;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'size',
        'type',
        'color',
        'is_in_stock',
        'price'
    ];

    public function orders() : MorphMany {
        return $this->morphMany(Order::class, 'orderable');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($product) {
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

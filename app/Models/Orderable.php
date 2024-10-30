<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Orderable extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'orderable_id',
        'orderable_type',
        'quantity',
        'published',
        'position'
    ];

    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

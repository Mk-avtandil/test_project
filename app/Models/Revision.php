<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Model;

class Revision extends Model 
{
    use HasMedias, HasFiles;

    protected $fillable = [
        'published',
        'title',
        'description',
    ];
    
}

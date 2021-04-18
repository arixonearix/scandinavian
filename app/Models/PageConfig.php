<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PageConfig
 * @package App\Models
 * @property integer $rows how much thumbnails shown in a row
 * @property integer $cols how much thumbnails shown in a row
 * @property integer $thumbCount how much thumbnails shown in a row
 */
class PageConfig extends Model
{
    use HasFactory;
    protected $table = 'page_config';

    public function getConfig($type): PageConfig
    {
        return self::where('name', self::MAIN_PAGE_CONFIG)
            ->get()
            ->first();
    }
}

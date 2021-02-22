<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pdf
 * @package App\Models
 * @property integer id
 * @property string filename
 * @property integer active
 */
class Pdf extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $table = 'scandinavian_pdf';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename',
        'active'
    ];

}

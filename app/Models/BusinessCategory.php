<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $table = 'business_categories';

    protected $primaryKey = 'id_category';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'deskripsi',
    ];

    public function smeProfiles()
    {
        return $this->hasMany(SmeProfile::class, 'id_category', 'id_category');
    }
}

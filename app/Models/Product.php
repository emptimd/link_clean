<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Product
 *
 * @package App
 * @version August 22, 2017, 5:17 pm EEST
 * @property int $id
 * @property string $name
 * @property string $fastspring_name
 * @property bool $is_extras
 * @property float $price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MarketProduct[] $marketProducts
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereFastspringName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereIsExtras($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product wherePrice($value)
 * @mixin \Eloquent
 */
class Product extends Model
{

    public $table = 'products';

    public $timestamps = false;


    public $fillable = [
        'name',
        'fastspring_name',
        'is_extras',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'fastspring_name' => 'string',
        'is_extras' => 'boolean',
        'price' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function marketProducts()
    {
        return $this->hasMany(\App\Models\MarketProduct::class);
    }
}

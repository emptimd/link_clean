<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class MarketProduct
 *
 * @package App
 * @version August 22, 2017, 5:18 pm EEST
 * @property int $id
 * @property int $market_id
 * @property int $product_id
 * @property-read \App\Models\Market $market
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketProduct whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketProduct whereMarketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketProduct whereProductId($value)
 * @mixin \Eloquent
 */
class MarketProduct extends Model
{

    public $table = 'market_products';
    
    public $timestamps = false;



    public $fillable = [
        'market_id',
        'product_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'market_id' => 'integer',
        'product_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function market()
    {
        return $this->belongsTo(\App\Models\Market::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}

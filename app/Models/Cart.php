<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * @property integer $id
 * @property integer $user_id
 * @property AsArrayObject $products
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Cart extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'products',
    ];
    /**
     * @var string[]
     * вместо array указал AsArrayObject чтобы можно было делать так: $cart->products[$request->product_id] = 1;
     */
    protected $casts = [
        'products' => AsArrayObject::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}

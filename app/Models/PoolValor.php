<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PoolValor
 *
 * @property int $id
 * @property int $id_pool
 * @property string $cd_valor
 * @property string $ds_valor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PoolValorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor query()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor whereCdValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor whereDsValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor whereIdPool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolValor whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Pool|null $pool
 */
class PoolValor extends Model
{
    use HasFactory;

    protected $table = 'pools_valores';
 
    public function pool()
    {
        return $this->hasOne(Pool::class, 'id', 'id_pool');
    }    
}

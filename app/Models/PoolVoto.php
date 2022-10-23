<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PoolVoto
 *
 * @property int $id
 * @property int $id_pool
 * @property int $id_user
 * @property string $cd_valor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto whereCdValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto whereIdPool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolVoto whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Pool|null $pool
 * @property-read \App\Models\User|null $usuario
 */
class PoolVoto extends Model
{
    protected $table = 'pools_votos';
 
    public function pool()
    {
        return $this->hasOne(Pool::class, 'id', 'id_pool');
    }
    
    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }    
}

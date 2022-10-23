<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pool
 *
 * @property int $id
 * @property string $ds_titulo
 * @property string $ds_descricao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PoolFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Pool newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pool newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pool query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pool whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pool whereDsDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pool whereDsTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pool whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pool whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pool extends Model
{
    use HasFactory;

    protected $table = 'pools';
}

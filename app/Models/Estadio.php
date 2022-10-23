<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Estadio
 *
 * @property int $id
 * @property string $ds_nome
 * @property string $ds_foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio whereDsFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Estadio extends Model
{
    protected $table = 'estadios';
}

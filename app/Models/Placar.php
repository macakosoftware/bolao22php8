<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Placar
 *
 * @property int $id
 * @property string $ds_placar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Placar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Placar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Placar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Placar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Placar whereDsPlacar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Placar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Placar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Placar extends Model
{
    public const OUTROS_PLACARES = "OUTROS";
    public const MAIS_DE_4 = "MAIS DE 4";
    
    protected $table = 'placares';
}

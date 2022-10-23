<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Handcap
 *
 * @property int $id
 * @property string $ds_handcap
 * @property int $nr_pontuacao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap query()
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap whereDsHandcap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap whereNrPontuacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Handcap whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Handcap extends Model
{
    public const PERCENTUAL_CASA = 25;
    
    protected $table = 'handcaps';
    
}

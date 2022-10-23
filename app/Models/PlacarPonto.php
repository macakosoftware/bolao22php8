<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\PlacarPonto
 *
 * @property int $id
 * @property int $cd_placar
 * @property int $nr_dif_inicial
 * @property int $nr_dif_final
 * @property float $qt_pontos1
 * @property float $qt_pontos2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Placar|null $placar
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereCdPlacar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereNrDifFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereNrDifInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereQtPontos1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereQtPontos2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlacarPonto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlacarPonto extends Model
{
    protected $table = 'placares_pontos';
    
    public function placar(): HasOne
    {
        return $this->hasOne(Placar::class, 'id', 'cd_placar');
    }
}

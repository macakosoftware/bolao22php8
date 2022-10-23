<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Ranking
 *
 * @property int $id
 * @property int $cd_ranking
 * @property int $id_user
 * @property int $qt_acertos_cheio
 * @property int $qt_acertos_parcial
 * @property int $qt_acertos_resultado
 * @property float $qt_pontos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $qt_pontos_resultado
 * @property float $qt_pontos_placar_cheio
 * @property float $qt_pontos_placar_parcial
 * @property float $qt_pontos_maior
 * @property int $qt_apostas
 * @property int $qt_posicao
 * @property-read \App\Models\TipoRanking|null $tipoRanking
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereCdRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtAcertosCheio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtAcertosParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtAcertosResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtApostas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtPontos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtPontosMaior($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtPontosPlacarCheio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtPontosPlacarParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtPontosResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereQtPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ranking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ranking extends Model
{
    protected $table = 'rankings';
    
    public function tipoRanking(): BelongsTo
    {
        return $this->belongsTo(TipoRanking::class, 'cd_ranking');
    }
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

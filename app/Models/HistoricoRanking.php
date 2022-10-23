<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HistoricoRanking
 *
 * @property int $id
 * @property string $dt_hr_ranking
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
 * @property int $qt_posicao
 * @property-read \App\Models\TipoRanking|null $tipoRanking
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking query()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereCdRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereDtHrRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtAcertosCheio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtAcertosParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtAcertosResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtPontos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtPontosMaior($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtPontosPlacarCheio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtPontosPlacarParcial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtPontosResultado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereQtPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoRanking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HistoricoRanking extends Model
{
    protected $table = 'historicos_rankings';
    
    public function tipoRanking()
    {
        return $this->hasOne('App\Models\TipoRanking', 'id', 'cd_ranking');
    }
    
    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}

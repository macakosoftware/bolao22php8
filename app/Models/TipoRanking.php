<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\TipoRanking
 *
 * @property int $id
 * @property string $ds_nome
 * @property string $dt_limite
 * @property string $hr_limite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $cd_status
 * @property int $qt_apostas
 * @property string $tp_fase
 * @property int $id_grupo
 * @property string $ds_badge
 * @property bool $id_handicap_casa
 * @property string $tp_serie
 * @property string $ds_abreviado
 * @property float $pc_premio1
 * @property float $pc_premio2
 * @property float $pc_premio3
 * @property-read \App\Models\StatusRanking|null $statusRanking
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking query()
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereCdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereDsAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereDsBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereDtLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereHrLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereIdGrupo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereIdHandicapCasa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking wherePcPremio1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking wherePcPremio2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking wherePcPremio3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereQtApostas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereTpFase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereTpSerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoRanking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TipoRanking extends Model
{
    public const TIPO_FASE_GERAL = 'G';
    public const TIPO_FASE_SIMPLES = 'S';
    public const TIPO_FASE_COMPOSTO = 'C';
    
    public const TIPO_SERIE_A = "A";
    public const TIPO_SERIE_B = "B";
    
    protected $table = 'tipos_rankings';
    
    public function statusRanking(): HasOne
    {
        return $this->hasOne(StatusRanking::class, 'id', 'cd_status');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Jogo
 *
 * @property int $id
 * @property int $id_selecao1
 * @property int $id_selecao2
 * @property string $dt_jogo
 * @property string $hr_jogo
 * @property int $id_estadio
 * @property int $cd_status
 * @property int $qt_gols_selecao1
 * @property int $qt_gols_selecao2
 * @property int $cd_ranking
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $ds_selecao1
 * @property string $ds_selecao2
 * @property int $id_vencedor
 * @property int $qt_gols_penal_selecao1
 * @property int $qt_gols_penal_selecao2
 * @property string $nr_pontos_handcap1
 * @property string $nr_pontos_handcapX
 * @property string $nr_pontos_handcap2
 * @property bool $id_penal
 * @property-read \App\Models\Estadio|null $estadio
 * @property-read \App\Models\Selecao|null $selecao1
 * @property-read \App\Models\Selecao|null $selecao2
 * @property-read \App\Models\StatusJogo|null $statusJogo
 * @property-read \App\Models\TipoRanking|null $tipoRanking
 * @method static \Database\Factories\JogoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereCdRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereCdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereDsSelecao1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereDsSelecao2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereDtJogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereHrJogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereIdEstadio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereIdPenal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereIdSelecao1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereIdSelecao2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereIdVencedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereNrPontosHandcap1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereNrPontosHandcap2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereNrPontosHandcapX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereQtGolsPenalSelecao1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereQtGolsPenalSelecao2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereQtGolsSelecao1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereQtGolsSelecao2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Jogo extends Model
{
    use HasFactory;

	public const PONTOS_BONUS = 2;
	
    protected $table = 'jogos';
 
    public function selecao1(): BelongsTo
    {
        return $this->belongsTo(Selecao::class, 'id_selecao1');
    }
    
    public function selecao2(): BelongsTo
    {
        return $this->belongsTo(Selecao::class, 'id_selecao2');
    }
    
    public function estadio(): BelongsTo
    {
        return $this->belongsTo(Estadio::class, 'id_estadio');
    }
    
    public function tipoRanking(): BelongsTo
    {
        return $this->belongsTo(TipoRanking::class, 'cd_ranking');
    }
    
    public function statusJogo(): BelongsTo
    {
        return $this->belongsTo(StatusJogo::class, 'cd_status');
    }

}

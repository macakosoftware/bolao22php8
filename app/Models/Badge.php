<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Badge
 *
 * @property int $id
 * @property string $ds_nome
 * @property int $cd_ranking
 * @property int $id_posicao
 * @property int $nr_posicao
 * @property bool $id_maior_pontuacao
 * @property bool $id_placares_cheios
 * @property bool $id_resultados
 * @property string $ds_link_badge
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TipoRanking|null $tipoRanking
 * @method static \Illuminate\Database\Eloquent\Builder|Badge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge query()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereCdRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereDsLinkBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIdMaiorPontuacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIdPlacaresCheios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIdPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIdResultados($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereNrPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Badge extends Model
{    
    public const SEM_BADGE = "sem_trofeu.png";
    
    protected $table = 'badges';
   
    public function tipoRanking()
    {
        return $this->hasOne('App\Models\TipoRanking', 'id', 'cd_ranking');
    }
}

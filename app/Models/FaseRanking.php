<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FaseRanking
 *
 * @property int $id
 * @property int $id_ranking_composto
 * @property int $id_ranking_simples
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking query()
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking whereIdRankingComposto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking whereIdRankingSimples($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaseRanking whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\TipoRanking|null $tipoRankingComposto
 * @property-read \App\Models\TipoRanking|null $tipoRankingSimples
 */
class FaseRanking extends Model
{
    protected $table = 'fases_rankings';
    
    public function tipoRankingComposto()
    {
        return $this->hasOne(TipoRanking::class, 'id', 'id_ranking_composto');
    }
    
    public function tipoRankingSimples()
    {
        return $this->hasOne(TipoRanking::class, 'id', 'id_ranking_simples');
    }
}

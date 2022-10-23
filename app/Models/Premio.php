<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Premio
 *
 * @property int $id
 * @property int $id_user
 * @property int $cd_ranking
 * @property int $nr_posicao
 * @property string $pc_premio
 * @property string $vl_premio
 * @property int $cd_pagamento
 * @property string $ds_observacao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $dt_hr_pagamento
 * @method static \Illuminate\Database\Eloquent\Builder|Premio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Premio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Premio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereCdPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereCdRanking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereDsObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereDtHrPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereNrPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio wherePcPremio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premio whereVlPremio($value)
 * @mixin \Eloquent
 * @property-read \App\Models\FormaPagamento|null $formaPagamneto
 * @property-read \App\Models\TipoRanking|null $tipoRanking
 * @property-read \App\Models\User|null $usuario
 */
class Premio extends Model
{
    protected $table = 'premios';
 
    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    
    public function tipoRanking()
    {
        return $this->hasOne(TipoRanking::class, 'id', 'cd_ranking');
    }
    
    public function formaPagamneto()
    {
        return $this->hasOne(FormaPagamento::class, 'id', 'cd_pagamento');
    }
}

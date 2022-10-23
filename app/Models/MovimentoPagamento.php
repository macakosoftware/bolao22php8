<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\MovimentoPagamento
 *
 * @property int $id
 * @property int $id_user
 * @property int $cd_forma
 * @property string $vl_movimento
 * @property string $dt_hr_pagamento
 * @property string $ds_observacao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $vl_joia
 * @property-read \App\Models\FormaPagamento|null $formaPagamento
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereCdForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereDsObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereDtHrPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereVlJoia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovimentoPagamento whereVlMovimento($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $usuario
 */
class MovimentoPagamento extends Model
{   
    protected $table = 'movimentos_pagamentos';
    
    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function formaPagamento(): HasOne
    {
        return $this->hasOne(FormaPagamento::class, 'id', 'cd_forma');
    }
}

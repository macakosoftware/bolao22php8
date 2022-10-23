<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pagamento
 *
 * @property int $id
 * @property string $ds_pagamento
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento whereDsPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pagamento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pagamento extends Model
{
    public const PENDENTE_PAGAMENTO = 1;
    public const PAGO = 2;
    
    protected $table = 'pagamentos';
}

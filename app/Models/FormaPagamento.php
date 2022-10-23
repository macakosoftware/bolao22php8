<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FormaPagamento
 *
 * @property int $id
 * @property string $ds_nome
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormaPagamento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FormaPagamento extends Model
{
    protected $table = 'formas_pagamentos';
}

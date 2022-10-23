<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HistCreditoUsuario
 *
 * @property int $id
 * @property string $tp_movimento
 * @property string $vl_movimento
 * @property string $ds_observacao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id_user
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereDsObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereTpMovimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistCreditoUsuario whereVlMovimento($value)
 * @mixin \Eloquent
 */
class HistCreditoUsuario extends Model
{
    public const TIPO_MOVIMENTO_ENTRADA = 'E'; 
    public const TIPO_MOVIMENTO_SAIDA = 'S'; 
    
    protected $table = 'hist_creditos_usuarios';
         
    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}

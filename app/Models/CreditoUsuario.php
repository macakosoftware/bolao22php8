<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CreditoUsuario
 *
 * @property int $id
 * @property int $id_user
 * @property string $vl_credito
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditoUsuario whereVlCredito($value)
 * @mixin \Eloquent
 */
class CreditoUsuario extends Model
{
    protected $table = 'creditos_usuarios';
 
        
    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}

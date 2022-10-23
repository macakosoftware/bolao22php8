<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NotificacaoLida
 *
 * @property int $id
 * @property int $id_notificacao
 * @property int $id_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida whereIdNotificacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoLida whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Notificacao|null $notificacao
 * @property-read \App\Models\User|null $usuario
 */
class NotificacaoLida extends Model
{
    protected $table = 'notificacoes_lidas';
 
    public function notificacao()
    {
        return $this->hasOne(Notificacao::class, 'id', 'id_notificacao');
    }
           
    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}

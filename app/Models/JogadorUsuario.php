<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JogadorUsuario
 *
 * @property int $id
 * @property int $id_jogador
 * @property int $id_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jogador|null $jogador
 * @property-read \App\Models\User|null $usuario
 * @method static \Database\Factories\JogadorUsuarioFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario whereIdJogador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JogadorUsuario whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JogadorUsuario extends Model
{
    use HasFactory;

    protected $table = 'jogadores_usuarios';

    public function jogador()
    {
        return $this->hasOne('App\Models\Jogador', 'id', 'id_jogador');
    }
    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}

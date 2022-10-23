<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\AvisoAposta
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_jogo
 * @property string $tp_aviso
 * @property bool $id_enviado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jogo|null $jogo
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereIdEnviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereIdJogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereTpAviso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvisoAposta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AvisoAposta extends Model
{
    public const TIPO_AVISO_24 = '1';
    public const TIPO_AVISO_48 = '2';
    public const TIPO_AVISO_72 = '3';
    
    protected $table = 'avisos_apostas';
 
    public function jogo(): HasOne
    {
        return $this->hasOne(Jogo::class, 'id', 'id_jogo');
    }
    
    public function usuario(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}

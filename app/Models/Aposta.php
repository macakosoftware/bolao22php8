<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Aposta
 *
 * @property int $id
 * @property int $id_jogo
 * @property int $qt_gols_selecao1
 * @property int $qt_gols_selecao2
 * @property int $id_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id_selecao_penal
 * @property-read \App\Models\Jogo|null $jogo
 * @property-read \App\Models\Selecao|null $selecaoPenal
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereIdJogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereIdSelecaoPenal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereQtGolsSelecao1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereQtGolsSelecao2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Aposta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Aposta extends Model
{
    protected $table = 'apostas';
 
    public function jogo(): BelongsTo
    {
        return $this->belongsTo(Jogo::class, 'id_jogo');
    }
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function selecaoPenal(): BelongsTo
    {
        return $this->belongsTo(Selecao::class, 'id_selecao_penal');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\PropostaJogador
 *
 * @property int $id
 * @property int $id_proposta
 * @property int $id_jogador
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jogador|null $jogador
 * @property-read \App\Models\TransacaoProposta|null $proposta
 * @method static \Database\Factories\PropostaJogadorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador whereIdJogador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador whereIdProposta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropostaJogador whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PropostaJogador extends Model
{
    use HasFactory;

    protected $table = 'propostas_jogadores';

    public function proposta(): HasOne
    {
        return $this->hasOne(TransacaoProposta::class, 'id', 'id_proposta');
    }
    public function jogador(): HasOne
    {
        return $this->hasOne(Jogador::class, 'id', 'id_jogador');
    }    
}

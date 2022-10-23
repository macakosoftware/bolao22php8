<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TransacaoProposta
 *
 * @property int $id
 * @property int $id_transacao
 * @property int $id_user_proposta
 * @property int $vl_proposta
 * @property string $cd_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $ds_observacao
 * @property string $ds_resposta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropostaJogador[] $jogadoresTroca
 * @property-read int|null $jogadores_troca_count
 * @property-read \App\Models\TransacaoFigurinha|null $transacao
 * @property-read \App\Models\User|null $usuarioProposta
 * @method static \Database\Factories\TransacaoPropostaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereCdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereDsObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereDsResposta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereIdTransacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereIdUserProposta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoProposta whereVlProposta($value)
 * @mixin \Eloquent
 */
class TransacaoProposta extends Model
{
    use HasFactory;

    public const STATUS_ENVIADA = 'E';
    public const STATUS_ACEITA = 'A';
    public const STATUS_REJEITADA = 'R';
    public const STATUS_CANCELADA = 'C';
        
    protected $table = 'transacoes_propostas';

    public function transacao(): BelongsTo
    {
        return $this->belongsTo(TransacaoFigurinha::class, 'id_transacao');
    }
    public function usuarioProposta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_proposta');
    }
    public function jogadoresTroca(): HasMany
    {
        return $this->hasMany(PropostaJogador::class, 'id_proposta', 'id');
    }
}

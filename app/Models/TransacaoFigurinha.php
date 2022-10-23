<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\TransacaoFigurinha
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_jogador
 * @property string $tp_transacao
 * @property float $vl_venda
 * @property string $cd_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $ds_observacao
 * @property-read \App\Models\Jogador|null $jogador
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TransacaoProposta[] $propostas
 * @property-read int|null $propostas_count
 * @property-read \App\Models\User|null $usuario
 * @method static \Database\Factories\TransacaoFigurinhaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereCdStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereDsObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereIdJogador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereTpTransacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransacaoFigurinha whereVlVenda($value)
 * @mixin \Eloquent
 */
class TransacaoFigurinha extends Model
{
    use HasFactory;

    public const STATUS_ABERTA = 'A';
    public const STATUS_FECHADA = 'F';
    
    public const TIPO_TROCA = 'T';
    public const TIPO_VENDA = 'V';
    
    public const VALOR_MAXIMO_VENDA = 100;
        
    protected $table = 'transacoes_figurinhas';

    public function usuario(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function jogador(): HasOne
    {
        return $this->hasOne(Jogador::class, 'id', 'id_jogador');
    }
    public function propostas(): HasMany
    {
        return $this->hasMany(TransacaoProposta::class, 'id_transacao', 'id');
    }
}

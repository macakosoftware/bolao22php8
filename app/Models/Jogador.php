<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Jogador
 *
 * @property int $id
 * @property int $id_selecao
 * @property string $ds_selecao
 * @property string $ds_numero
 * @property string $ds_nome
 * @property string $ds_abreviado
 * @property string $ds_posicao
 * @property string $dt_nascimento
 * @property string $ds_time
 * @property string $ds_valor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id_posicao
 * @property int $vl_preco
 * @property int $nr_ini_random
 * @property int $nr_fim_random
 * @property string $tp_jogador
 * @property int $nr_camisa
 * @property-read \App\Models\Posicao|null $posicao
 * @property-read \App\Models\Selecao|null $selecao
 * @method static \Database\Factories\JogadorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsSelecao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDsValor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereDtNascimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereIdPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereIdSelecao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereNrCamisa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereNrFimRandom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereNrIniRandom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereTpJogador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jogador whereVlPreco($value)
 * @mixin \Eloquent
 */
class Jogador extends Model
{
    use HasFactory;

    public const PRECO_MAXIMO = 400;
    
    public const TIPO_GOLDEN = 'G';
    public const TIPO_SILVER = 'S';
    public const TIPO_NORMAL = 'N';
    
    protected $table = 'jogadores';

    public function selecao(): HasOne
    {
        return $this->hasOne(Selecao::class, 'id', 'id_selecao');
    }
    public function posicao(): HasOne
    {
        return $this->hasOne(Posicao::class, 'id', 'id_posicao');
    }
}

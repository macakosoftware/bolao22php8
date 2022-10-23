<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Posicao
 *
 * @property int $id
 * @property string $ds_nome
 * @property string $ds_abreviado
 * @property string $cd_posicao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao query()
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao whereCdPosicao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao whereDsAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posicao whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Posicao extends Model
{
    public const GUARDA_REDES = 'Guarda-Redes';
    public const DEFESA_CENTRAL = 'Defesa Central';
    public const LATERAL_ESQUERDO = 'Lateral Esquerdo';
    public const LATERAL_DIREITO = 'Lateral Direito';
    public const MEDIO_DEFENSIVO = 'Médio Defensivo';
    public const MEDIO_CENTRAL = 'Médio Central';
    public const MEDIO_OFENSIVO = 'Médio Ofensivo';
    public const EXTREMO_ESQUERDO = 'Extremo Esquerdo';
    public const EXTREMO_DIREITO = 'Extremo Direito';
    public const PONTA_DE_LANCA = 'Ponta de Lança';
    public const SEGUNDO_AVANCADO = 'Segundo Avançado';
    public const MEDIO_ESQUERDO = 'Médio Esquerdo';
    public const MEDIO_DIREITO = 'Médio Direito';
    
    public const COD_GOLEIRO = 1;
    public const COD_ZAGUEIRO = 2;
    public const COD_LATERAL_DIREITO = 3;
    public const COD_LATERAL_ESQUERDO = 4;
    public const COD_MEIA_DEFENSIVO = 5;
    public const COD_MEIA_CENTRAL = 6;
    public const COD_PONTA_ESQUERDA = 7;
    public const COD_PONTA_DIREITA = 8;
    public const COD_PONTA_LANCA = 9;
    public const COD_ATACANTE = 10;
    public const COD_ALA_ESQUERDO = 11;
    public const COD_ALA_DIREITO = 12;
    
    protected $table = 'posicoes';

}

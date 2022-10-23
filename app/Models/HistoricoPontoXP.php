<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HistoricoPontoXP
 *
 * @property int $id
 * @property int $id_user
 * @property string $tp_transacao
 * @property string $dt_transacao
 * @property string $ds_transacao
 * @property float $vl_transacao
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP query()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereDsTransacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereDtTransacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereTpTransacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoricoPontoXP whereVlTransacao($value)
 * @mixin \Eloquent
 */
class HistoricoPontoXP extends Model
{
    public const TIPO_ENTRADA = 'E';
    public const TIPO_SAIDA = 'S';
    
    protected $table = 'historicos_pontos_xp';
    
    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
}

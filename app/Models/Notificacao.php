<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notificacao
 *
 * @property int $id
 * @property string $ds_icon
 * @property string $ds_cor
 * @property string $ds_texto
 * @property string $ds_numero
 * @property string $ds_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $ds_descricao
 * @property int $tp_notificacao
 * @method static \Database\Factories\NotificacaoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereDsCor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereDsDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereDsIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereDsLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereDsNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereDsTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereTpNotificacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacao whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notificacao extends Model
{
    use HasFactory;

    public const TIPO_SIMPLES = 1;
    public const TIPO_PESOS_TIMES = 2;
    
    protected $table = 'notificacoes';
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NotificacaoAlbum
 *
 * @property int $id
 * @property int $id_user
 * @property string $tp_notificacao
 * @property int $id_transacao
 * @property int $id_proposta
 * @property string $tp_resposta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id_user_from
 * @property bool $id_lido
 * @property string $ds_observacao
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereDsObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereIdLido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereIdProposta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereIdTransacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereIdUserFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereTpNotificacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereTpResposta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificacaoAlbum whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificacaoAlbum extends Model
{
    public const TIPO_NOTIFICACAO_OFERTA = 'O';
    public const TIPO_NOTIFICACAO_PROPOSTA = 'P';
    
    public const TIPO_RESPOSTA_ENVIADO = 'E';
    public const TIPO_RESPOSTA_CANCELADO = 'C';
    public const TIPO_RESPOSTA_APROVADO = 'A';
    public const TIPO_RESPOSTA_REJEITADO = 'R';
    
    protected $table = 'notificacoes_album';
    
}

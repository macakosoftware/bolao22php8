<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Destinatario
 *
 * @property int $id
 * @property int $id_mensagem
 * @property int $id_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $id_lido
 * @property-read \App\Models\Mensagem|null $mensagem
 * @property-read \App\Models\User|null $usuarioPara
 * @method static \Database\Factories\DestinatarioFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario query()
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario whereIdLido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario whereIdMensagem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Destinatario whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Destinatario extends Model
{
    use HasFactory;

    protected $table = 'destinatarios';
    
    public function mensagem(): BelongsTo
    {
        return $this->belongsTo(Mensagem::class, 'id_mensagem');
    }
    
    public function usuarioPara(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Mensagem
 *
 * @property int $id
 * @property int $id_user_from
 * @property string $ds_mensagem 
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id_mensagem_relacionada
 * @property string $ds_titulo
 * @property-read \App\Models\User|null $usuarioDe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Destinatario[] $destinatarios
 * @method static \Database\Factories\MensagemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem whereIdUserFrom($value) 
 * @method static \Illuminate\Database\Eloquent\Builder|Mensagem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mensagem extends Model
{

    use HasFactory;

    protected $table = 'mensagens';

    public function usuarioDe(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user_from');
    }

    public function destinatarios(): HasMany
    {
        return $this->hasMany(Destinatario::class, 'id_mensagem', 'id');
    }
}

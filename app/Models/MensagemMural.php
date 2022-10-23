<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MensagemMural
 *
 * @property int $id
 * @property int $id_user
 * @property string $ds_mensagem 
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at 
 * @property-read \App\Models\User|null $usuario 
 * @method static \Database\Factories\MensagemMuralFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural query()
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural whereIdUser($value) 
 * @method static \Illuminate\Database\Eloquent\Builder|MensagemMural whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MensagemMural extends Model
{
    protected $table = 'mensagens_mural';
    
    public function usuario()
    {
        return $this->hasOne('App\User', 'id', 'id_user');
    }    
}

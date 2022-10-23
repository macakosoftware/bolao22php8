<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mural
 *
 * @property int $id
 * @property string $ds_mensagem
 * @property int $id_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mural newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mural newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mural query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mural whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mural whereDsMensagem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mural whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mural whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mural whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $usuario
 */
class Mural extends Model
{
    protected $table = 'murais';
    
    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}

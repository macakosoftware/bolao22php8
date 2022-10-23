<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Perfil
 *
 * @property int $id
 * @property string $ds_perfil
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil query()
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil whereDsPerfil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Perfil whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Perfil extends Model
{
    const PERFIL_ADMINISTRADOR = 1;
    const PERFIL_ADM_CONTEUDO = 2;
    const PERFIL_USUARIO = 3;
    
    protected $table = 'perfis';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatusJogo
 *
 * @property int $id
 * @property string $ds_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo whereDsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusJogo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusJogo extends Model
{    
    public const JOGO_PROGRAMADO = 1;
    public const JOGO_FINALIZADO = 2;
    public const JOGO_PREVISTO = 3;
    public const JOGO_APOSTA_ENCERRADA = 4;
    
    protected $table = 'status_jogos';    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Selecao
 *
 * @property int $id
 * @property string $ds_nome
 * @property string $ds_icone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id_grupo
 * @property int $cd_handcap
 * @property string $ds_cor
 * @property string $ds_fonte
 * @property string $ds_cor2
 * @property-read \App\Models\Grupo|null $grupo
 * @property-read \App\Models\Handcap|null $handcap
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao query()
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereCdHandcap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereDsCor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereDsCor2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereDsFonte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereDsIcone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereDsNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereIdGrupo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Selecao whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Selecao extends Model
{
    const PAGINA_MAXIMA_ALBUM = 32;
    
    protected $table = 'selecoes';
    
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }
    
    public function handcap(): HasOne
    {
        return $this->hasOne('App\Models\Handcap', 'id', 'cd_handcap');
    }
}

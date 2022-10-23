<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatusRanking
 *
 * @property int $id
 * @property string $ds_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking whereDsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatusRanking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatusRanking extends Model
{
    public const ABERTO = 1;
    public const FECHADO = 2;
    
    protected $table = 'status_rankings';
}

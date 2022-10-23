<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\BadgeUser
 *
 * @property int $id
 * @property int $id_badge
 * @property int $id_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Badge|null $badge
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser whereIdBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BadgeUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BadgeUser extends Model
{    
    protected $table = 'badges_users';
        
    public function badge(): HasOne
    {
        return $this->hasOne(Badge::class, 'id', 'id_badge');
    }
    
    public function usuario(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}

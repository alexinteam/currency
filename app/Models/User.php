<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 * @package App\Models
 * @property integer $id
 * @property string $name
 */
class User extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'user';

    /**
     * @return HasMany
     */
    public function accounts() : HasMany
    {
        return $this->HasMany(Account::class, 'user_id', 'id');
    }
}

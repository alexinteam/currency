<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Account
 * @package App\Models
 * @property integer $id
 * @property integer $user_id
 * @property boolean $is_receiving
 * @property float $amount
 * @property integer $master_currency
 */
class Account extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'account';

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function currency() : HasOne
    {
        return $this->HasOne(Currency::class, 'id', 'master_currency');
    }
}

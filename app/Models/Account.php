<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account
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
        return $this->HasOne(Currency::class, 'currency_id', 'id');
    }
}

<?php


namespace App\Repositories;


use App\Exceptions\AccountTransferException;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class AccountRepository
{
    /**
     * @param int|null $id
     * @return Account|null
     */
    public function find(?int $id) : ?Account
    {
        return Account::where('id', '=', $id)->with('currency')->first();
    }

    /**
     * @param Account $sender
     * @param Account $reciever
     * @return bool
     * @throws AccountTransferException
     */
    public function transferTransaction(Account $sender, Account $reciever) : bool
    {
        try {
            DB::beginTransaction();
            $sender->save();
            $reciever->save();

            return true;
        } catch (\Exception $exception) {
            DB::rollback();
            throw new AccountTransferException('Transactions not saved');
        }
    }
}

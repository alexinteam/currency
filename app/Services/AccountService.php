<?php


namespace App\Services;


use App\Exceptions\AccountTransferException;
use App\Exceptions\AllCurrencyApilayerException;
use App\Models\Account;
use App\Repositories\AccountRepository;

class AccountService
{
    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @var CurrencyLayerInterface
     */
    protected $currencyService;

    public function __construct(AccountRepository $accountRepository, CurrencyLayerInterface $currencyService)
    {
        $this->accountRepository = $accountRepository;
        $this->currencyService = $currencyService;
    }

    /**
     * @param int|null $id
     * @return Account|null
     */
    public function find(?int $id) : ?Account
    {
        return $this->accountRepository->find($id);
    }

    /**
     * @param Account $sender
     * @param Account $reciever
     * @param float $amount
     * @throws AccountTransferException
     * @throws AllCurrencyApilayerException
     */
    public function transfer(Account $sender, Account $reciever, float $amount)
    {
        if($sender->is_receiving) {
            throw new AccountTransferException('sender can only send money');
        }

        if(!$reciever->is_receiving) {
            throw new AccountTransferException('reciever can only receive money');
        }

        try {
            $receivingAmount = $this->currencyService->convert(
                $sender->currency()->currency,
                $reciever->currency()->currency,
                $amount
            );

            $sender->amount = $sender->amount - $amount;
            $reciever->amount = $reciever->amount - $receivingAmount;

            $this->accountRepository->transferTransaction($sender, $reciever);
        } catch (AllCurrencyApilayerException $e) {
            throw $e;
        } catch (AccountTransferException $e) {
            throw $e;
        }
    }
}

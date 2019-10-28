<?php


namespace App\Http\Controllers;


use App\Exceptions\AccountTransferException;
use App\Exceptions\AllCurrencyApilayerException;
use App\Http\Requests\TransferRequest;
use App\Services\AccountService;
use App\Services\CurrencyLayerInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @var AccountService
     */
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param TransferRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(TransferRequest $request)
    {
        $senderId = $request->get('sender_id', null);
        $recieverId = $request->get('reciever_id', null);
        $amount  = $request->get('reciever_id', null);

        $sender = $this->accountService->find($senderId);
        $reciever = $this->accountService->find($recieverId);

        try {
            $this->accountService->transfer($sender, $reciever, $amount);
        } catch (AllCurrencyApilayerException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ],500);
        } catch (AccountTransferException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ],500);
        }

        return response()->json([
            'success' => 'true',
        ]);
    }

}

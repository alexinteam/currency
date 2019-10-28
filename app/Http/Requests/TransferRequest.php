<?php


namespace App\Http\Requests;


use Illuminate\Http\Request;

class TransferRequest extends Request
{
    public const RECIEVER_ID = 'reciever_id';
    public const SENDER_ID   = 'sender_id';
    public const AMOUNT      = 'amount';

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            self::RECIEVER_ID => 'required|integer|min:0|exists:account,id',
            self::SENDER_ID  => 'required|integer|min:0|exists:account,id',
            self::AMOUNT  => 'required|numeric|min:0.01',
        ];
    }

    /**
     * @return array
     */
    public function messages() : array
    {
        return [
            self::RECIEVER_ID => 'reciever_id should be integer and > 0',
            self::SENDER_ID  => 'reciever_id should be integer and > 0',
            self::AMOUNT  => 'amount should be numeric and > 0.01',
        ];
    }
}

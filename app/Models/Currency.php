<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public const USD = 'USD';
    public const EUR = 'EUR';
    public const GBP = 'GBP';
    public const RON = 'RON';
    public const COP = 'COP';

    /**
     * @var string $table
     */
    protected $table = 'currency';
}

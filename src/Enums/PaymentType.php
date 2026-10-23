<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum PaymentType: string
{
    use HasValues;

    case CASH = 'CASH';
    case NONINTEGRATEDCARD = 'NONINTEGRATEDCARD';
    case CHECK = 'CHECK';
    case WORLDPAY = 'WORLDPAY';
    case COINEY = 'COINEY';
    case IZETTLE = 'IZETTLE';
    case SUMUP = 'SUMUP';
    case TYRO = 'TYRO';
    case CHECURITY = 'CHECURITY';
    case SMARTPAY = 'SMARTPAY';
    case YOCO = 'YOCO';
    case NICEPAY = 'NICEPAY';
    case PAYGATE = 'PAYGATE';
    case EZETAP = 'EZETAP';
    case FIRSTDATA = 'FIRSTDATA';
    case SOFTBANK = 'SOFTBANK';
    case ONEPAY = 'ONEPAY';
    case KICC = 'KICC';
    case MERCADOPAGO = 'MERCADOPAGO';
    case OTHER = 'OTHER';
}

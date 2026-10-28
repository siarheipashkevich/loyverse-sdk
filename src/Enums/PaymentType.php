<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum PaymentType: string
{
    use HasValues;

    case Cash = 'CASH';
    case NonIntegratedCard = 'NONINTEGRATEDCARD';
    case Check = 'CHECK';
    case Worldpay = 'WORLDPAY';
    case Coiney = 'COINEY';
    case IZettle = 'IZETTLE';
    case SumUp = 'SUMUP';
    case Tyro = 'TYRO';
    case Checurity = 'CHECURITY';
    case SmartPay = 'SMARTPAY';
    case Yoco = 'YOCO';
    case NicePay = 'NICEPAY';
    case PayGate = 'PAYGATE';
    case Ezetap = 'EZETAP';
    case FirstData = 'FIRSTDATA';
    case SoftBank = 'SOFTBANK';
    case OnePay = 'ONEPAY';
    case Kicc = 'KICC';
    case MercadoPago = 'MERCADOPAGO';
    case Other = 'OTHER';
}

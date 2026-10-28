<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum WebhookStatus: string
{
    use HasValues;

    case Enabled = 'ENABLED';
    case Disabled = 'DISABLED';
}

<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case General = 'general';
    case Billing = 'billing';
    case Technical = 'technical';
    case Other = 'other';

}

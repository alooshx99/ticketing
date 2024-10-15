<?php

namespace App\Enums;

enum TicketStatusEnum: string
{
    case Open = 'open';
    case Closed = 'closed';
}

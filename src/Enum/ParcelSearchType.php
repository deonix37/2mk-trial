<?php

namespace App\Enum;

enum ParcelSearchType: string
{
    case SENDER_PHONE = 'sender_phone';
    case RECEIVER_FULLNAME = 'receiver_fullname';
}

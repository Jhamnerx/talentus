<?php

namespace App\Enums\WhatsFleep;

enum ConversationStatus: string
{
    case Open = 'open';
    case Pending = 'pending';
    case Closed = 'closed';
}

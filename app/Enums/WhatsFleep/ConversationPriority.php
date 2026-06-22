<?php

namespace App\Enums\WhatsFleep;

enum ConversationPriority: string
{
    case Low = 'low';
    case Normal = 'normal';
    case High = 'high';
    case Emergency = 'emergency';
}

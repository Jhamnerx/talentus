<?php

namespace App\Enums\WhatsFleep;

enum MessageSenderType: string
{
    case Contact = 'contact';
    case Agent = 'agent';
    case System = 'system';
}

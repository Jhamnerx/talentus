<?php

namespace App\Enums\WhatsFleep;

enum MessageType: string
{
    case Text = 'text';
    case Image = 'image';
    case Audio = 'audio';
    case Video = 'video';
    case Document = 'document';
    case Location = 'location';
    case Contact = 'contact';
    case Sticker = 'sticker';
}

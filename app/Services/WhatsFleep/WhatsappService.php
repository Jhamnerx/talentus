<?php

namespace App\Services\WhatsFleep;

interface WhatsappService
{
    public function fetchGroups($device): object;
    public function fetchContacts($device): object;
    public function sendText($token, $number, $message): object;
    public function syncHistory($token, $jid, $count, array $oldestMsgKey, $oldestMsgTimestamp): object;
    public function sendMedia($token, $number, $type, $url, $caption = '', $fileName = ''): object;
    public function sendImageBase64($token, $number, $base64Image, $caption = ''): object;
    public function sendButton($token, $number, $message, $buttons, $footer = '', $image = ''): object;
    public function sendTemplate($token, $number, $message, $buttons, $footer = '', $image = ''): object;
    public function sendList($token, $number, $message, $sections, $footer = '', $title = '', $buttonText = ''): object;
    public function sendContact($token, $number, $contactName, $contactNumber): object;
    public function sendLocation($token, $number, $latitude, $longitude, $name = ''): object;
    public function sendBulk($token, $messages, $delay = 1000): object;
    public function checkStatus($token): object;
    public function checkWhatsapp($token, $number): object;
}

<?php

declare(strict_types=1);

namespace app\services\senders;

interface SenderService
{
    public function setTo(string $to): self;
    public function setMessage(string $message): self;
    public function send(): bool;
    public function setError(string $error): void;
    public function getError(): string;
}
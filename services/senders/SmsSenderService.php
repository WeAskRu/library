<?php

declare(strict_types=1);

namespace app\services\senders;

class SmsSenderService implements SenderService
{
    private const API_URL = 'http://smspilot.ru/api.php';
    private const API_KEY = 'VU1K1UC604OB259ADU2L3479VD22A3Z87H2KUL97UH663P52EJ19U5I693Q3S738';

    private string $to;
    private string $message;
    private string $error = '';

    public function setTo(string $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function send(): bool
    {
        $result = file_get_contents($this->getUrl());
        if (str_starts_with($result, 'SUCCESS')) {
            return true;
        } else {
            $this->setError('Ошибка отправки SMS ' . $result . '!');
            return false;
        }
    }

    public function setError(string $error): void
    {
        $this->error = $error;
    }

    public function getError(): string
    {
        return $this->error;
    }

    private function getUrl(): string
    {
        $params = [
            'send' => $this->message,
            'to' => $this->to,
            'apikey' => self::API_KEY,
        ];
        return self::API_URL . '?' . http_build_query($params);
    }
}
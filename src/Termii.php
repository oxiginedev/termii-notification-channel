<?php

declare(strict_types=1);

namespace Oxiginedev\Termii;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Oxiginedev\Termii\Data\Media;
use Oxiginedev\Termii\Enums\Channel;
use Oxiginedev\Termii\Exceptions\TermiiFailedToSendException;

final class Termii
{
    public function sendSms(string $to, string $message, Channel $channel): array
    {
        return $this->send($to, $message, $channel);
    }

    public function sendWhatsapp(string $to, string $message, ?Media $media = null): array
    {
        return $this->send($to, $message, Channel::WHATSAPP, $media);
    }

    private function send(string $to, string $message, Channel $channel, ?Media $media = null): array
    {
        $payload = [
            'api_key' => config('services.termii.key'),
            'from' => config('services.termii.sender'),
            'to' => $to,
            'sms' => $message,
            'channel' => $channel->value,
            'type' => 'plain',
        ];

        if ($media instanceof Media && $channel === Channel::WHATSAPP) {
            unset($payload['sms']);
            $payload['media'] = $media->toArray();
        }

        $response = $this->getClient()->post('api/sms/send', $payload);

        if (! $response->successful()) {
            throw new TermiiFailedToSendException(
                $response->json('message') ?? 'Termii send failed'
            );
        }

        return $response->json();
    }

    private function getClient(): PendingRequest
    {
        return Http::baseUrl(config('services.termii.url'))
            ->asJson()
            ->acceptJson()
            ->throw();
    }
}

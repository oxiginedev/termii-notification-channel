<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel;

use Adedaramola\TermiiNotificationChannel\Enums\Channel;
use Adedaramola\TermiiNotificationChannel\Enums\Type;
use Adedaramola\TermiiNotificationChannel\Exceptions\TermiiFailedToSendException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Termii
{
    private static Channel $defaultSmsChannel = Channel::GENERIC;

    public static function useDefaultSmsChannel(Channel $channel): void
    {
        if (! in_array($channel, Channel::defaultSmsChannels())) {
            throw new InvalidArgumentException(
                sprintf("Channel [%s] can't be used as a default sms channel", $channel->value)
            );
        }

        self::$defaultSmsChannel = $channel;
    }

    public function sendSms(string $to, string $message, Type $type, ?Channel $channel): array
    {
        return $this->send($to, $message, $type, $channel ?? self::$defaultSmsChannel);
    }

    public function sendWhatsapp(string $to, string $message, Type $type, ?string $mediaUrl = null, ?string $mediaCaption = null): array
    {
        return $this->send($to, $message, $type, Channel::WHATSAPP, $mediaUrl, $mediaCaption);
    }

    private function send(string $to, string $message, Type $type, Channel $channel, ?string $mediaUrl = null, ?string $mediaCaption = null): array
    {
        $payload = [
            'api_key' => config('services.termii.key'),
            'from' => config('services.termii.sender'),
            'to' => $to,
            'sms' => $message,
            'channel' => $channel->value,
            'type' => $type->value,
        ];

        if (($mediaUrl || $mediaCaption) && $channel === Channel::WHATSAPP) {
            unset($payload['sms']);
            $payload['media'] = [
                'url' => $mediaUrl,
                'caption' => $mediaCaption,
            ];
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

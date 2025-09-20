<?php

namespace App\Services;

use OpenSSLAsymmetricKey;
use UnexpectedValueException;

class JwtService
{
    private int $algorithm;
    private OpenSSLAsymmetricKey $privateKey;
    private OpenSSLAsymmetricKey $publicKey;

    public function __construct(string $algorithm = OPENSSL_ALGO_SHA256)
    {
        $this->algorithm = $algorithm;
        $this->privateKey = openssl_pkey_get_private(file_get_contents(storage_path('private.pem')));
        $this->publicKey = openssl_pkey_get_public(file_get_contents(storage_path('public.pem')));
    }

    public function encode(array $payload): string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $encodedHeader = $this->base64encode(json_encode($header));
        $encodedPayload = $this->base64encode(json_encode($payload));
        $data = $encodedHeader . '.' . $encodedPayload;
        if (!openssl_sign($data, $signature, $this->privateKey, $this->algorithm)) {
            throw new UnexpectedValueException('Unable to sign token.');
        }
        $encodedSignature = $this->base64encode($signature);
        return $encodedHeader . '.' . $encodedPayload . '.' . $encodedSignature;
    }

    private function base64encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function decode(string $jwt): array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            throw new UnexpectedValueException('Invalid token structure.');
        }
        [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;
        $data = $encodedHeader . '.' . $encodedPayload;
        $signature = $this->base64decode($encodedSignature);
        $isValid = openssl_verify($data, $signature, $this->publicKey, $this->algorithm);
        if ($isValid !== 1) {
            throw new UnexpectedValueException('Invalid token signature.');
        }
        $payload = json_decode($this->base64decode($encodedPayload), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new UnexpectedValueException('Invalid payload JSON.');
        }
        return $payload;
    }

    private function base64decode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

<?php
declare(strict_types=1);

final class PayFast
{
    public function __construct(private PayFastSdk $sdk)
    {
    }

    public function charge(float $amount): string
    {
        $payload = [
            'reference' => uniqid('pf_'),
            'amount_cents' => (int) round($amount * 100),
            'currency' => 'EUR'
        ];

        $result = $this->sdk->executePayment($payload);

        if (!$result['success']) {
            throw new RuntimeException('PayFast payment failed');
        }

        return $result['transaction_id'];
    }
}
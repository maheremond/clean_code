<?php
declare(strict_types=1);

final class BookingService
{
    public function __construct(
        private BookingCalculator $calculator,
        private BookingReactions $reactions,
        private object $paymentClient
    ) {
    }

    public function confirm(Booking $booking): float
    {
        $booking->validate();

        $total = $this->calculator->calculate($booking);

        $this->supervisePayment($total);

        $booking->status = 'confirmed';
        echo "SQL INSERT booking={$booking->id} total={$total} status={$booking->status}" . PHP_EOL;

        $this->reactions->trigger($booking, $total);

        return $total;
    }

    private function supervisePayment(float $amount): void
    {
        $start = microtime(true);
        error_log(sprintf('Paiement demandé : %.2f EUR', $amount));

        try {
            $this->paymentClient->charge($amount);
            error_log('Résultat du paiement : succès');
        } catch (Throwable $exception) {
            error_log('Résultat du paiement : échec');
            throw $exception;
        } finally {
            $duration = microtime(true) - $start;
            error_log(sprintf('Durée du paiement : %.4f secondes', $duration));
        }
    }
}
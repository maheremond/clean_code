<?php
declare(strict_types=1);

final class BookingCalculator
{
    public function calculate(Booking $booking): float
    {
        $total = $this->calculateBaseTotal($booking);
        $total = $this->applyVipDiscount($booking->customer->type, $total);
        $total = $this->applyPassDiscount($booking->passType, $total);

        return $this->ensurePositive($total);
    }

    private function calculateBaseTotal(Booking $booking): float
    {
        $total = 0.0;
        foreach ($booking->items as $item) {
            $total += $item->ticket->price * $item->quantity;
        }
        return $total;
    }

    private function applyVipDiscount(string $customerType, float $total): float
    {
        if ($customerType !== 'vip') {
            return $total;
        }

        if ($total < 100.0) {
            return $total * 0.95;
        }

        if ($total < 300.0) {
            return $total * 0.90;
        }

        return $total * 0.85;
    }

    private function applyPassDiscount(string $passType, float $total): float
    {
        if ($passType === '3days') {
            return $total - 20.0;
        }

        return $total;
    }

    private function ensurePositive(float $total): float
    {
        if ($total < 0.0) {
            return 0.0;
        }

        return $total;
    }
}
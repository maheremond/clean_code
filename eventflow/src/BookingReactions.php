<?php
declare(strict_types=1);

final class BookingReactions
{
    public function __construct(
        private EmailService $email,
        private LoyaltyService $loyalty,
        private AnalyticsClient $analytics,
        private SmsClient $sms
    ) {
    }

    public function trigger(Booking $booking, float $total): void
    {
        $this->email->sendConfirmation($booking->customer->email, $booking->id);
        $this->loyalty->addPoints($booking->customer->id, (int) round($total));
        
        $total = round($total, 2);

        $this->analytics->track('booking_confirmed', [
            'booking_id' => $booking->id,
            'total' => $total
        ]);

        $this->sendSmsIfNeeded($booking);
    }

    private function sendSmsIfNeeded(Booking $booking): void
    {
        if ($booking->customer->phone !== null) {
            $this->sms->send($booking->customer->phone, "Votre réservation {$booking->id} est confirmée.");
        }
    }
}
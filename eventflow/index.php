<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

$customer = new Customer(
    id: 42,
    email: 'lea@example.com',
    phone: '0612345678',
    type: 'vip'
);

$dayTicket = new Ticket(
    code: 'DAY-1',
    label: 'Pass Jour 1',
    price: 79.90
);

$booking = new Booking(
    id: 1001,
    customer: $customer,
    passType: 'day'
);

$booking->addItem(new BookingItem($dayTicket, 2));

$calculator = new BookingCalculator();
$reactions = new BookingReactions(
    email: new EmailService(),
    loyalty: new LoyaltyService(),
    analytics: new AnalyticsClient(),
    sms: new SmsClient()
);
$paymentClient = new StripeClient();

$service = new BookingService($calculator, $reactions, $paymentClient);
$total = $service->confirm($booking);

echo 'TOTAL : ' . number_format($total, 2, '.', '') . PHP_EOL;
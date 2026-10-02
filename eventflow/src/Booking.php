<?php
declare(strict_types=1);

final class Booking
{
    /** @var BookingItem[] */
    public array $items = [];
    public string $status = 'pending';

    public function __construct(
        public int $id,
        public Customer $customer,
        public string $passType = 'day'
    ) {
    }

    public function addItem(BookingItem $item): void
    {
        $this->items[] = $item;
    }

    public function validate(): void
    {
        $this->customer->validate();

        if (count($this->items) === 0) {
            throw new RuntimeException('Empty booking');
        }

        foreach ($this->items as $item) {
            $item->validate();
        }
    }
}
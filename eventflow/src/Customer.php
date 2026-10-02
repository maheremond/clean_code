<?php
declare(strict_types=1);

final class Customer
{
    public function __construct(
        public int $id,
        public string $email,
        public ?string $phone = null,
        public string $type = 'standard'
    ) {
    }

    public function validate(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Invalid email');
        }
    }
}
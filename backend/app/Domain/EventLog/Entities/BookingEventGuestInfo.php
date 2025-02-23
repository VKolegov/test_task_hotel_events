<?php

namespace App\Domain\EventLog\Entities;

readonly class BookingEventGuestInfo
{
    public function __construct(
        public int $id,
        public string $fullName,
        public string $phone,
        public string $email,
        public string $documentInfo,

    ) {
    }

    public static function multipleFromArray(array $data): array
    {
        return array_map(
            static fn(array $arrayElement) => self::fromArray($arrayElement),
            $data
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['full_name'],
            $data['phone'],
            $data['email'],
            $data['document_info']
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'full_name' => $this->fullName,
            'phone' => $this->phone,
            'email' => $this->email,
            'document_info' => $this->documentInfo,
        ];
    }
}

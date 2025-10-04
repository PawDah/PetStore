<?php

namespace App\Dto;

class PetDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $status,
        public array $photoUrls = [],
    ) {}

    /**
     * Tworzenie DTO z surowej tablicy zwróconej przez API.
     */
    public static function fromApiArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            name: $data['name'] ?? 'Unknown Pet',
            status: $data['status'] ?? 'available',
            photoUrls: $data['photoUrls'] ?? [],
        );
    }

    /**
     * Konwersja DTO na tablicę do wysłania do API w razie potrzeby .
     */
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'photoUrls' => $this->photoUrls,
        ];
    }
}

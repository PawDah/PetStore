<?php

namespace App\Interfaces;

use App\Dto\PetDTO;
use Exception;
interface PetStoreApiInterface
{
    public function addPet(array $data): PetDTO;
    public function getPet(int $id): PetDTO;
    public function updatePet(array $data): PetDTO;
    public function deletePet(int $id): array;
}

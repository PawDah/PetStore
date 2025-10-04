<?php

namespace App\Services;

namespace App\Services;

use App\Interfaces\PetStoreApiInterface;
use App\DTO\PetDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use Exception;
use Throwable;

class PetStoreApiService implements PetStoreApiInterface
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('api.petstore.base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @throws Exception
     */
    public function addPet(array $data): PetDTO
    {
        $response = $this->request('POST', '/v2/pet', ['json' => $data]);
        return PetDTO::fromApiArray($response);
    }

    /**
     * @throws Exception
     */
    public function getPet(int $id): PetDTO
    {
        $response = $this->request('GET', "/v2/pet/{$id}");
        return PetDTO::fromApiArray($response);
    }

    /**
     * @throws Exception
     */
    public function updatePet(array $data): PetDTO
    {
        if (!isset($data['id'])) {
            throw new Exception("Wymagane ID do aktualizacji.");
        }
        $response = $this->request('PUT', '/v2/pet', ['json' => $data]);
        return PetDTO::fromApiArray($response);
    }

    /**
     * @throws Exception
     */
    public function deletePet(int $id): array
    {
        return $this->request('DELETE', "/v2/pet/{$id}");
    }

    /**
     * @throws Exception
     */
    private function request(string $method, string $uri, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $uri, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            Log::error("API Client Error ({$statusCode}): " . $e->getMessage());
            throw new Exception("Błąd API (kod: {$statusCode}): " . $this->extractErrorMessage($e));
        } catch (Throwable $e) {
            Log::error('General API Error: ' . $e->getMessage());
            throw new Exception("Ogólny błąd: " . $e->getMessage());
        }
    }

    private function extractErrorMessage(ClientException $e): string
    {
        try {
            $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
            return $responseBody['message'] ?? $e->getMessage();
        } catch (Throwable $ex) {
            return $e->getMessage();
        }
    }
}

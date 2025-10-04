<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'sometimes|integer|min:1',
            'name' => 'required|string|max:255',
            'photo_url' => 'required|url|max:255',
            'status' => 'required|in:available,pending,sold',
        ];
    }

    /**
     * Tworze wymaganą przez API tablicę 'photoUrls' z pojedynczego 'photo_url'.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'photoUrls' => $this->photo_url ? [$this->photo_url] : [],
        ]);
    }

    /**
     * Zwracam tylko minimalnie potrzebne dane dla Serwisu.
     */
    public function validated($key = null, $default = null)
    {

        return $this->only(['id', 'name', 'status', 'photoUrls']);
    }
}

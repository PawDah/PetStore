<?php

namespace App\Http\Controllers;

use App\Interfaces\PetStoreApiInterface;
use App\Http\Requests\PetStoreRequest;
use App\DTO\PetDTO;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;

class PetController extends Controller
{
    protected PetStoreApiInterface $petStoreService;

    public function __construct(PetStoreApiInterface $petStoreService)
    {
        $this->petStoreService = $petStoreService;
    }

    public function index(Request $request): Factory|View
    {
        $pet = null;
        $error = null;

        if ($request->has('id')) {
            $id = $request->id;
            try {
                $pet = $this->petStoreService->getPet($id);
            } catch (Exception $e) {
                $error = "Błąd: " . $e->getMessage();
            }
        }

        return view('pet.index', compact('pet', 'error'));
    }

    public function store(PetStoreRequest $request)
    {
        $validated = $request->validated();
        try {
            $result = $this->petStoreService->addPet($validated);
            return redirect('/pet')->with('success', 'Zwierzak dodany! ID: ' . $result->id ."Imie: " .$result->name);
        } catch (Exception $e) {
            return redirect('/pet')->with('error', 'Błąd podczas dodawania: ' . $e->getMessage())->withInput();
        }
    }

    public function update(PetStoreRequest $request)
    {
        $validated = $request->validated();

        try {
            $result = $this->petStoreService->updatePet($validated);
            return redirect('/pet')->with('success', 'Zwierzak ID ' . $result->id . ' zaktualizowany.');
        } catch (Exception $e) {
            return redirect('/pet')->with('error', 'Błąd podczas aktualizacji: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request): Redirector|RedirectResponse
    {
        $validated = $request->validate([ 'id' => 'required|integer|min:1' ]);

        try {
            $this->petStoreService->deletePet($validated['id']);
            return redirect('/pet')->with('success', 'Zwierzak ID ' . $validated['id'] . ' usunięty.');
        } catch (Exception $e) {
            return redirect('/pet')->with('error', 'Błąd podczas usuwania: ' . $e->getMessage());
        }
    }
}

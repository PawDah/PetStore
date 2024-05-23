<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PharIo\Version\Exception;

class ApiController extends Controller
{
    protected string $baseUrl='http://petstore.swagger.io/v2/pet';

    /**
     * Display a listing of the resource.
     */
    public function index($status): View
    {
        //get all available pets
        $fetchPets=Http::get($this->baseUrl . '/findByStatus?status='.$status);
        $pets=json_decode($fetchPets->body());
        //Limit all pets from api to 10
        $limitedPets=array_slice($pets, 0, 10);
        return view("pets.index", ["pets"=>$limitedPets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->post();
        $prepareData=['name'=>$data['name'],'photoUrls'=>[$data['url']]];
        try {
            $addPet=Http::post($this->baseUrl,json_encode($prepareData));
            return view("home", ["status"=>$addPet->status()]);
        }catch (Exception $e){
            return $e;
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fetchPet=Http::get($this->baseUrl.$id);
        $pet=json_decode($fetchPet->body());
        return view('pets.edit',['pet'=>$pet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $response=Http::delete($this->baseUrl . '/'.$id);
            return response()->json([
                'status'=>$response->status()
            ]);
        }catch (Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>'Wystąpił błąd!'
            ])->setStatusCode(500);
        }
    }
}

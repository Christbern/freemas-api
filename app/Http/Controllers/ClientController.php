<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController
{

    protected ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = $this->clientRepository->getAll();
        return response()->json(['success' => true, 'clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $client = $this->clientRepository->store($request->validated());
        return response()->json(['success' => true, 'client' => $client, 'message' => 'Client created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = $this->clientRepository->getById($id);
        return response()->json(['success' => true, 'client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        $this->clientRepository->update($id, $request->validated());
        return response()->json(['success' => true, 'message' => 'Client updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->clientRepository->destroy($id);
        return response()->json(['success' => true, 'message' => 'Client deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteRequest;
use App\Repositories\SiteRepository;
use Illuminate\Http\Request;

class SiteController
{
    protected SiteRepository $siteRepository;

    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = $this->siteRepository->getAll();
        return response()->json(['success' => true, 'sites' => $sites]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiteRequest $request)
    {
        $site = $this->siteRepository->store($request->validated());
        return response()->json([
            'success' => true,
            'site' => $site,
            'message' => 'Site created successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $site = $this->siteRepository->getById($id);
        return response()->json(['success' => true, 'site' => $site,]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiteRequest $request, string $id)
    {
        $this->siteRepository->update($id, $request->validated());
        return response()->json(['success' => true, 'message' => 'Site updated successfully.',]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->siteRepository->destroy($id);
        return response()->json(['success' => true, 'message' => 'Site deleted successfully.',]);
    }
}

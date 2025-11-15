<?php

namespace App\Http\Controllers;

use App\Http\Requests\QualificationRequest;
use App\Repositories\QualificationRepository;
use Illuminate\Http\Request;

class QualificationController
{

    protected QualificationRepository $qualificationRepository;

    public function __construct(QualificationRepository $qualificationRepository)
    {
        $this->qualificationRepository = $qualificationRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->qualificationRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QualificationRequest $request)
    {
        $qualification = $this->qualificationRepository->store($request->validated());
        return response()->json(['success' => true, 'qualification' => $qualification]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $qualification = $this->qualificationRepository->getById($id);
        return response()->json(['success' => true, 'qualification' => $qualification]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->qualificationRepository->update($id, $request->validated());
        return response()->json(['success' =>true, 'message' => 'Qualification updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->qualificationRepository->destroy($id);
        return response()->json(['success' => true, 'message' => 'Qualification deleted successfully.']);
    }
}

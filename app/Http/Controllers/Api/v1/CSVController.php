<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Service\CSVService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CSVController extends Controller
{

    public function __construct(
        private readonly CSVService $csvService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function compare(Request $request): JsonResponse
    {
        $path1 = $request->file('csv1')->getRealPath();
        $path2 = $request->file('csv2')->getRealPath();

        $data1 = $this->csvService->readCSV($path1);
        $data2 = $this->csvService->readCSV($path2);

        $differences = $this->csvService->findDifferences($data1, $data2);

        return new JsonResponse(['differences' => $differences], ResponseAlias::HTTP_OK);
    }
}

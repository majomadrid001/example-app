<?php

namespace App\Http\Controllers;

use App\Http\Services\VehicleFilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class VehicleController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $data = [];
        $data['type'] = $request->input('type', 0);
        $data['usecase'] = $request->input('usecase', 0);
        $data['price'] = $request->input('price', []);
        $data['range'] = $request->input('range', []);
        $data['contractDuration'] = $request->input('contractDuration', []);
        $data['motorway'] = $request->boolean('motorway');
        $data['driversLicense'] = $request->boolean('driversLicense');
        $data['topBox'] = $request->boolean('topBox');
        $data['orderBy'] = $request->input('orderBy', 0);
        $full = $request->boolean('full');

        $vehicleFilter = new VehicleFilterService($data);

        return response()->json($vehicleFilter->output($full));
    }
}

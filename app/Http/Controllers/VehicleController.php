<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class VehicleController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $type = $request->input('type', 0);
        $usecase = $request->input('usecase', 0);
        $price = $request->input('price', []);
        $range = $request->input('range', []);
        $contractDuration = $request->input('contract_duration', []);
        $motorway = $request->boolean('motorway');
        $driversLicense = $request->boolean('drivers_license');
        $topBox = $request->boolean('top_box');
        $orderBy = $request->input('order_by', 1);

        // I will generate a json output with the reviews and images included
        $vehicles = Vehicle::with('reviews:vehicle_id,stars', 'images:vehicle_id,name,primary');

        // filter by client type
        if (!empty($type)) {
            $vehicles = $vehicles->where('type_id', $type);
        }

        // filter bu use case
        if (!empty($usecase)) {
            $vehicles = $vehicles->where('usecase_id', $usecase);
        }

        // filter by selected price range (I numbered the checkboxes 1-4)
        if (!empty($price)) {
            $vehicles = $vehicles->where(function ($query) use ($price) {
                if (in_array(1, $price)) {
                    $query->orWhere('price', '<', 100);
                }
                if (in_array(2, $price)) {
                    $query->orWhereBetween('price', [100, 150]);
                }
                if (in_array(3, $price)) {
                    $query->orWhereBetween('price', [151, 200]);
                }
                if (in_array(4, $price)) {
                    $query->orWhere('price', '>', 200);
                }
            });
        }

        // filter by vehicle range (I numbered the checkboxes 1-3)
        if (!empty($range)) {
            $vehicles = $vehicles->where(function ($query) use ($range) {
                if (in_array(1, $range)) {
                    $query->orWhere('range', '<', 70);
                }
                if (in_array(2, $range)) {
                    $query->orWhereBetween('range', [70, 100]);
                }
                if (in_array(3, $range)) {
                    $query->orWhere('range', '>', 100);
                }
            });
        }

        // filter by contract duration (I chose to use the actual durations instead of numbering the checkboxes)
        if (!empty($contractDuration)) {
            $vehicles = $vehicles->where(function ($query) use ($contractDuration) {
                if (in_array(1, $contractDuration)) {
                    $query->orWhere('contract_duration', 12);
                }
                if (in_array(2, $contractDuration)) {
                    $query->orWhere('contract_duration', 24);
                }
                if (in_array(3, $contractDuration)) {
                    $query->orWhere('contract_duration', 36);
                }
                if (in_array(4, $contractDuration)) {
                    $query->orWhere('contract_duration', 48);
                }
                if (in_array(5, $contractDuration)) {
                    $query->orWhere('contract_duration', 60);
                }
            });
        }

        // the remaining checkboxes
        if ($motorway) {
            $vehicles = $vehicles->where('motorway', 1);
        }
        if ($driversLicense) {
            $vehicles = $vehicles->where('drivers_license', 1);
        }
        if ($topBox) {
            $vehicles = $vehicles->where('top_box', 1);
        }

        // order either by price lowest to highest or the other way around
        if ($orderBy==1) {
            $vehicles->orderBy('price', 'asc');
        }
        if ($orderBy==2) {
            $vehicles->orderBy('price', 'desc');
        }

        return response()->json($vehicles->get());
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Type;
use App\Models\Usecase;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class VehicleController extends Controller
{
    public function search(Request $request): AnonymousResourceCollection
    {
        $vehicles = Vehicle::query()
            ->when($request->type, fn ($query) => $query->OfType(Type::find($request->type)))
            ->when($request->usecase, fn ($query) => $query->OfUsecase(Usecase::find($request->usecase)))
            ->when($request->pricefrom, fn ($query) => $query->priceFrom($request->pricefrom))
            ->when($request->priceto, fn ($query) => $query->priceTo($request->priceto))
            ->when($request->range, fn ($query) => $query->hasRange($request->range))
            ->when($request->motorway, fn ($query) => $query->allowedForMotorways())
            ->when($request->driversLicense, fn ($query) => $query->driversLicenseNeeded())
            ->when($request->topbox, fn ($query) => $query->withTopBox())
            ->when($request->orderBy, fn ($query) => $query->orderByPrice($request->orderBy))
            ->paginate(30);

        return VehicleResource::collection($vehicles);
    }
}

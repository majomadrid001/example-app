<?php

namespace App\Http\Services;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;

class VehicleFilterService
{
    private Builder $vehicles;

    public function __construct(array $data)
    {
        $this->vehicles = Vehicle::with('reviews:vehicle_id,stars', 'images:vehicle_id,name,primary');
        foreach ($data as $filter => $filterValue) {
            $func = "filterBy" . strtoupper($filter);
            if (method_exists($this, $func)) {
                $this->$func($filterValue);
            }

        }
        if ($data['orderBy']==1) {
            $this->vehicles = $this->vehicles->orderBy('price', 'asc');
        } elseif ($data['orderBy']==2) {
            $this->vehicles = $this->vehicles->orderBy('price', 'desc');
        } else {
            $this->vehicles = $this->vehicles->orderBy('id');
        }

    }

    // filter by client type
    public function filterByType($type): void
    {
        if (!empty($type)) {
            $this->vehicles = $this->vehicles->where('type_id', $type);
        }
    }

    // filter by use case
    public function filterByUsecase($usecase): void
    {
        if (!empty($usecase)) {
            $this->vehicles = $this->vehicles->where('usecase_id', $usecase);
        }
    }

    // filter by selected price range (I numbered the checkboxes 1-4)
    public function filterByPrice($price): void
    {
        if (!empty($price)) {
            $this->vehicles = $this->vehicles->where(function ($query) use ($price) {
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
    }

    // filter by vehicle range (I numbered the checkboxes 1-3)
    public function filterByRange($range): void
    {
        if (!empty($range)) {
            $this->vehicles = $this->vehicles->where(function ($query) use ($range) {
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
    }

    // filter by contract duration (I chose to use the actual durations instead of numbering the checkboxes)
    public function filterByContractDuration($contractDuration): void
    {
        if (!empty($contractDuration)) {
            $this->vehicles = $this->vehicles->where(function ($query) use ($contractDuration) {
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
    }

    public function filterByMotorway($motorway): void
    {
        if ($motorway) {
            $this->vehicles = $this->vehicles->where('motorway', 1);
        }
    }

    public function filterByDriversLicense($driversLicense): void
    {
        if ($driversLicense) {
            $this->vehicles = $this->vehicles->where('drivers_license', 1);
        }
    }

    public function filterByTopBox($topBox): void
    {
        if ($topBox) {
            $this->vehicles = $this->vehicles->where('top_box', 1);
        }
    }

    public function output(bool $full = false): array
    {
        $output = [];
        $vehicles = $this->vehicles->get();
        foreach ($vehicles as $vehicle) {
            $reviews = $vehicle->reviews->count();
            $stars = 0;
            if ($reviews>0) {
                $totalStars = 0;
                foreach ($vehicle->reviews as $review) {
                    $totalStars += $review->stars;
                }
                $stars = $totalStars / $reviews;
            }
            $output[] = [
                'id' => $vehicle->id,
                'name' => $vehicle->name,
                'image' => $vehicle->images[0]?$vehicle->images[0]->name:'',
                'short_description' => $vehicle->short_description,
                'stars' => $stars,
                'price' => $vehicle->price,
            ];
        }
        if ($full) {
            return $this->vehicles->get()->toArray();
        }
        return $output;
    }
}

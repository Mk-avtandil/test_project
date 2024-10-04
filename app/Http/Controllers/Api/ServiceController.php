<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ServiceCollection
    {
        $per_page = $request->get('per_page') ?? 25;
        $services = Service::paginate($per_page);
        return new ServiceCollection($services);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): ServiceResource
    {
        return new ServiceResource($service);
    }

    public function getAllServices(Request $request): ServiceCollection
    {
        $cacheKey = "all_services";

        if (Cache::has($cacheKey)) {
            $services = Cache::get($cacheKey);
        } else {
            $services = Service::all();

            if ($services->isNotEmpty()) {
                Cache::put($cacheKey, $services, 60);
            }
        }
        return new ServiceCollection($services);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GooglePlacesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Gate;
use DB;

class LocationController extends Controller
{
    protected $googlePlaces;

    public function __construct(GooglePlacesService $googlePlaces)
    {
        $this->googlePlaces = $googlePlaces;
    }

    /**
     * Search for location suggestions
     */
    public function searchLocations(Request $request): JsonResponse
    {
		if(Gate::denies('intake_events_access'))
		{
			$request->validate([
				'query' => 'required|string|min:3',
				'types' => 'nullable|string',
				'location' => 'nullable|string',
				'radius' => 'nullable|integer|min:1|max:50000',
			]);

			$result = $this->googlePlaces->searchPlaces(
				$request->query,
				$request->types,
				$request->location,
				$request->radius
			);

			if ($result['success']) {
				return response()->json([
					'success' => true,
					'data' => $result['predictions']
				]);
			}

			return response()->json([
				'success' => false,
				'message' => 'Failed to fetch locations',
				'error' => $result['error']
			], 400);
		}
		else 
		{
			return response()->json([
				'success' => false,
				'message' => '403 Forbidden',
				'error' => Response::HTTP_FORBIDDEN
			], 413);
		}
    }
    
}
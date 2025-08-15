<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GooglePlacesService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://maps.googleapis.com/maps/api/place';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.google.places_api_key');
    }

    /**
     * Search for place predictions (autocomplete)
     */
    public function searchPlaces($query, $types = null, $location = null, $radius = null)
    {
        try {
            $params = [
                'input' => $query,
                'key' => $this->apiKey,
            ];

            if ($types) {
                $params['types'] = $types; // e.g., 'geocode', 'establishment', 'address'
            }

            if ($location && $radius) {
                $params['location'] = $location; // lat,lng
                $params['radius'] = $radius; // in meters
            }

            $response = $this->client->get($this->baseUrl . '/autocomplete/json', [
                'query' => $params
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'OK') {
                return [
                    'success' => true,
                    'predictions' => $data['predictions'],
                ];
            }

            return [
                'success' => false,
                'error' => $data['status'],
                'predictions' => [],
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'error' => 'API request failed: ' . $e->getMessage(),
                'predictions' => [],
            ];
        }
    }

    /**
     * Get place details by place_id
     */
    public function getPlaceDetails($placeId, $fields = null)
    {
        try {
            $params = [
                'place_id' => $placeId,
                'key' => $this->apiKey,
            ];

            if ($fields) {
                $params['fields'] = $fields; // e.g., 'geometry,name,formatted_address'
            } else {
                $params['fields'] = 'geometry,name,formatted_address,place_id,types';
            }

            $response = $this->client->get($this->baseUrl . '/details/json', [
                'query' => $params
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'OK') {
                return [
                    'success' => true,
                    'result' => $data['result'],
                ];
            }

            return [
                'success' => false,
                'error' => $data['status'],
                'result' => null,
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'error' => 'API request failed: ' . $e->getMessage(),
                'result' => null,
            ];
        }
    }

    /**
     * Search nearby places
     */
    public function searchNearby($location, $radius, $type = null, $keyword = null)
    {
        try {
            $params = [
                'location' => $location, // lat,lng
                'radius' => $radius, // in meters
                'key' => $this->apiKey,
            ];

            if ($type) {
                $params['type'] = $type; // e.g., 'restaurant', 'hospital'
            }

            if ($keyword) {
                $params['keyword'] = $keyword;
            }

            $response = $this->client->get($this->baseUrl . '/nearbysearch/json', [
                'query' => $params
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'OK') {
                return [
                    'success' => true,
                    'results' => $data['results'],
                    'next_page_token' => $data['next_page_token'] ?? null,
                ];
            }

            return [
                'success' => false,
                'error' => $data['status'],
                'results' => [],
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'error' => 'API request failed: ' . $e->getMessage(),
                'results' => [],
            ];
        }
    }
}
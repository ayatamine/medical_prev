<?php

namespace App\Http\Controllers\API\Mobile\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdsResource;
use App\Models\Ad;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;

class AdsController extends Controller
{
    private ApiResponse $api;
    public function __construct(ApiResponse $apiResponse)
    {
        $this->api = $apiResponse;
    }
        /**
      * @OA\Get(
      *      path="/api/v1/ads",
      *      operationId="ads_index",
      *      tags={"ads"},
      *      description="Get list of ads",
      *      @OA\Response(
      *          response=200,
      *          description="ads fetched successfuly",
      *          @OA\JsonContent()
      *       )
      *     )
      */
      public function index(){
        $ads = Ad::Publishable()
        ->latest()
        ->get()
        ->makeHidden(["api_route", "can","created_at","updated_at"])
        ->map(function($q){
            return new AdsResource($q);
        });

        $message = count($ads) ? 'ads fetched successfuly' : 'no ads founded';
        return $this->api->success()
        ->message($message)
        ->payload($ads)
        ->send();
      }
}

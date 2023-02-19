<?php

namespace App\Http\Controllers\API\Mobile\V1;

use App\Models\Scale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;

class ScaleController extends Controller
{
    private ApiResponse $api;
    public function __construct(ApiResponse $apiResponse)
    {
        $this->api = $apiResponse;
    }
        /**
      * @OA\Get(
      *      path="/api/v1/scales",
      *      operationId="index",
      *      tags={"scales"},
      *      description="Get list of patient scales",
      *      @OA\Response(
      *          response=200,
      *          description="data fetched successfuly",
      *          @OA\JsonContent()
      *       )
      *     )
      */
      public function index()
      {
          $scales = Scale::with(['scaleQuestions'=>function($q) {
                             $q->select(['id','scale_id','question','question_ar']);
                         }])
                         ->latest()
                         ->get()->makeHidden(["api_route", "can","created_at","updated_at"])->toArray();

          $message = count($scales) ? 'data fetched successfuly' : 'no scale founded';
          return $this->api->success()
          ->message($message)
          ->payload($scales)
          ->send();
        
      }
}

<?php

namespace App\Http\Controllers\API\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Models\FamilyHistory;
use Illuminate\Http\Request;




 class FamilyHistoryController extends Controller
 {
        /**
      * @OA\Get(
      *      path="/api/v1/family-histories",
      *      operationId="index",
      *      tags={"familyHistories"},
      *      description="Get list of family histories",
      *      @OA\Response(
      *          response=200,
      *          description="data fetched successfuly",
      *          @OA\JsonContent()
      *       )
      *     )
      */
     public function index()
     {
         $famiily_histories = FamilyHistory::select('name')->latest()->get()->makeHidden(["api_route", "can"])->toArray();
         $message = count($famiily_histories) ? 'data fetched successfuly' : 'no family history record founded';
         return response()->json(
             [
             "message" => $message,
             "data" => $famiily_histories
            ]
         ,200);
       
     }
 }

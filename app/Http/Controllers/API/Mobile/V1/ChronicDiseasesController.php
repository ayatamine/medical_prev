<?php

namespace App\Http\Controllers\API\Mobile\V1;

use App\Http\Controllers\Controller;
use App\Models\ChronicDisease;
use Illuminate\Http\Request;


class ChronicDiseasesController extends Controller
{
       /**
     * @OA\Get(
     *      path="/api/v1/chronic-diseases",
     *      operationId="getChronicDiseases",
     *      tags={"chronicDiseases"},
     *      description="Get list of chronic diseases",
     *      @OA\Response(
     *          response=200,
     *          description="data fetched successfuly",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function index()
    {
        $chronic_diseases = ChronicDisease::select('name')->latest()->get()->makeHidden(["api_route", "can"])->toArray();
        $message = count($chronic_diseases) ? 'data fetched successfuly' : 'no chronic diseases recodrd founded';
        return response()->json(
            [
            "message" => $message,
            "data" => $chronic_diseases
           ]
        ,200);
      
    }
    
 /**
     * @OA\Post(
     *      path="/api/patients/store",
     *      operationId="storepatient",
     *      tags={"patients"},
     *      summary="Store new patient",
     *      description="register new patient",
     *      @OA\RequestBody(
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        return response()->json(
            [
            "message" => "patient created successfuly ",
            "data" => []
           ]
        ,201);
    }
}

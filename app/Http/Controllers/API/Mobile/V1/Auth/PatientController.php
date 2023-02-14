<?php

namespace App\Http\Controllers\API\Mobile\V1\Auth;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PatientRequest;

class PatientController extends Controller
{

     /**
        * @OA\Post(
        * path="/api/v1/patients/otp/send",
        * operationId="sendOtp",
        * tags={"patients"},
        * summary="send patient otp to phone number",
        * description="send patient otp via to phone number via sms example +213684759496",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="application/x-www-form-urlencoded",
        *             @OA\Schema(
        *                 @OA\Property(
        *                     property="phone_number",
        *                     type="string",
        *                     example="+213664419425"
        *                 ),
        *                
        *             )
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="The otp sended successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=500,
        *          description="internal server error",
        *          @OA\JsonContent()
        *       )
        *     )
        */
        public function sendOtp(Request $request)
        {

            $request->validate([
                'phone_number' => 'required|regex:/^(\+\d{1,2}\d{10})$/'
            ]);
        $otp = generate_otp($request->phone_number,'Patient');
        return sendSMS($request->phone_number,'Your OTP code is ',$otp);
        
        }
        /**
        * @OA\Post(
        * path="/api/v1/patients/otp/verify",
        * operationId="loginWithOtp",
        * tags={"patients"},
        * summary="verify patient otp code if match to login",
        * description="verify patient otp code if match to login using the phone_number and the otp",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="application/x-www-form-urlencoded",
        *             @OA\Schema(
        *                 @OA\Property(
        *                     property="phone_number",
        *                     type="string",
        *                     example="+213664419425"
        *                 ),
        *                 @OA\Property(
        *                     property="otp",
        *                     type="string",
        *                     example="55555"
        *                 )
        *                
        *             )
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="The verification passed successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Your OTP Or Phone Number is not correct",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=419,
        *          description="Your OTP has been expired",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=500,
        *          description="internal server error",
        *          @OA\JsonContent()
        *       )
        *     )
        */
        public function loginWithOtp(Request $request)
        {
            /* Validation */
            $request->validate([
                'phone_number' => 'required|regex:/^(\+\d{1,2}\d{10})$/',
                'otp' => 'required'
            ]);  
    
            /* Validation Logic */
            $patient   = Patient::where('phone_number', $request->phone_number)->where('otp_verification_code', $request->otp)->first();
    
            $now = now();
            if (!$patient) {
                return response()->json([
                    'status' =>false,
                    'message'=>'Your OTP Or Phone Number is not correct'
                ],422);
            }else if($patient && $now->isAfter($patient->otp_expire_at)){
                return response()->json([
                    'status' =>false,
                    'message'=>'Your OTP has been expired'
                ],419);
            }
            //validate the otp
            $patient->otp_verification_code =  null;
            $patient->otp_expire_at =  now();
            $patient->save();

            return response()->json([
                'status'=>true,
                'data' =>[
                    'token' => $patient->createToken('mobile', ['role:patient','patient:update'])->plainTextToken,
                    'patient_id'=>$patient->id
                ] 
            ],200);

        }
        /**
        * @OA\Post(
        * path="/api/v1/patients/complete-medical-record",
        * operationId="storePatientData",
        * security={ {"sanctum": {} }},
        * tags={"patients"},
        * summary="update or complete patient medical record",
        * description="update or complete patient medical record ",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="application/x-www-form-urlencoded",
        *             @OA\Schema(
        *                 @OA\Property( property="full_name",type="string",example="ahmed amine"),
        *                 @OA\Property( property="birth_date",type="string",example="25-05-1995"),
        *                 @OA\Property( property="age",type="integer",example=28),
        *                 @OA\Property( property="gender",type="integer",example="male"),
        *                 @OA\Property( property="address",type="integer",example="adrar alg"),
        *                 @OA\Property( property="height",type="integer",example=180),
        *                 @OA\Property( property="weight",type="double",example="55.5"),
        *                 @OA\Property( property="allergy_id",type="integer",example=1),
        *                 @OA\Property( property="chronic_diseases_id",type="integer",example=1),
        *                 @OA\Property( property="family_history_id",type="integer",example=1),
        *                 @OA\Property( property="has_cancer_screening",type="boolean",enum={0, 1}),
        *                 @OA\Property( property="has_depression_screening",type="boolean",enum={0, 1}),
        *                 @OA\Property( property="other_problems",type="object"),
        *             )
        *        ),
        *    ),
        *    @OA\Response( response=200, description="Patient Record Completed Successfuly", @OA\JsonContent() ),
        *    @OA\Response( response=404,description="Patient not found with the given token or phone number, please login again", @OA\JsonContent()),
        *    @OA\Response(response=500,description="internal server error", @OA\JsonContent() )
        *    )
        */
        public function storePatientData(PatientRequest $request)
        {

          $patient = auth('sanctum') ? auth('sanctum')->user() : Patient::where('phone_number',$request->query('phone_number'))->firstOrFail();
          $patient->update($request->except('thumbnail','phone_number','other_problems'));
          
          //to set as mutator in patient model
          if($request->other_problems){
            $patient->update(['other_problems'=>json_encode($request->other_problems)]);
          }
          
          return response()->json([
            'status'=>true,
            'message'=>'Patient Record Completed Successfuly',
            'data' =>[
                'patient'=>$patient->makeHidden(["api_route", "can","created_at","updated_at","otp_verification_code","otp_expire_at"])
            ] 
          ]);
        }
}

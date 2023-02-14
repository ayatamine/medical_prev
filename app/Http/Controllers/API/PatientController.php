<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\IndexPatient;
use App\Http\Requests\Patient\StorePatient;
use App\Http\Requests\Patient\UpdatePatient;
use App\Http\Requests\Patient\DestroyPatient;
use App\Models\Patient;
use App\Repositories\Patients;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class PatientController  extends Controller
{
    private ApiResponse $api;
    private Patients $repo;
    public function __construct(ApiResponse $apiResponse, Patients $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexPatient $request)
    {
        $query = Patient::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('full_name')->title('Full Name')->sort()->searchable(),
            Column::name('birth_date')->title('Birth Date')->sort()->searchable(),
            Column::name('thumbnail')->title('Thumbnail')->sort()->searchable(),
            Column::name('phone_number')->title('Phone Number')->sort()->searchable(),
            Column::name('otp_verification_code')->title('Otp Verification Code')->sort()->searchable(),
            Column::name('gender')->title('Gender')->sort()->searchable(),
            Column::name('address')->title('Address')->sort()->searchable(),
            Column::name('height')->title('Height')->sort()->searchable(),
            Column::name('weight')->title('Weight')->sort()->searchable(),
            Column::name('otp_expire_at')->title('Otp Expire At')->sort()->searchable(),
            Column::name('notification_status')->title('Notification Status')->sort()->searchable(),
            Column::name('has_physical_activity')->title('Has Physical Activity')->sort()->searchable(),
            Column::name('has_cancer_screening')->title('Has Cancer Screening')->sort()->searchable(),
            Column::name('has_depression_screening')->title('Has Depression Screening')->sort()->searchable(),
            Column::name('account_status')->title('Account Status')->sort()->searchable(),
            Column::name('age')->title('Age')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Patients")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Patient::query()->select(Patient::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StorePatient $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatient $request)
    {
        try {
            $data = $request->sanitizedObject();
            $patient = $this->repo::store($data);
            return $this->api->success()->message('Patient Created')->payload($patient)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Patient $patient)
    {
        try {
            $payload = $this->repo::init($patient)->show($request);
            return $this->api->success()
                        ->message("Patient $patient->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePatient $request
     * @param {$modelBaseName} $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePatient $request, Patient $patient)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($patient)->update($data);
            return $this->api->success()->message("Patient has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyPatient $request, Patient $patient)
    {
        $res = $this->repo::init($patient)->destroy();
        return $this->api->success()->message("Patient has been deleted")->payload($res)->code(200)->send();
    }

}

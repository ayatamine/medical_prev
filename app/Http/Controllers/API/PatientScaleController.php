<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatientScale\IndexPatientScale;
use App\Http\Requests\PatientScale\StorePatientScale;
use App\Http\Requests\PatientScale\UpdatePatientScale;
use App\Http\Requests\PatientScale\DestroyPatientScale;
use App\Models\PatientScale;
use App\Repositories\PatientScales;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class PatientScaleController  extends Controller
{
    private ApiResponse $api;
    private PatientScales $repo;
    public function __construct(ApiResponse $apiResponse, PatientScales $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexPatientScale $request)
    {
        $query = PatientScale::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of PatientScales")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = PatientScale::query()->select(PatientScale::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StorePatientScale $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePatientScale $request)
    {
        try {
            $data = $request->sanitizedObject();
            $patientScale = $this->repo::store($data);
            return $this->api->success()->message('Patient Scale Created')->payload($patientScale)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param PatientScale $patientScale
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, PatientScale $patientScale)
    {
        try {
            $payload = $this->repo::init($patientScale)->show($request);
            return $this->api->success()
                        ->message("Patient Scale $patientScale->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePatientScale $request
     * @param {$modelBaseName} $patientScale
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePatientScale $request, PatientScale $patientScale)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($patientScale)->update($data);
            return $this->api->success()->message("Patient Scale has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PatientScale $patientScale
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyPatientScale $request, PatientScale $patientScale)
    {
        $res = $this->repo::init($patientScale)->destroy();
        return $this->api->success()->message("Patient Scale has been deleted")->payload($res)->code(200)->send();
    }

}

<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Allergy\IndexAllergy;
use App\Http\Requests\Allergy\StoreAllergy;
use App\Http\Requests\Allergy\UpdateAllergy;
use App\Http\Requests\Allergy\DestroyAllergy;
use App\Models\Allergy;
use App\Repositories\Allergies;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class AllergyController  extends Controller
{
    private ApiResponse $api;
    private Allergies $repo;
    public function __construct(ApiResponse $apiResponse, Allergies $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexAllergy $request)
    {
        $query = Allergy::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Allergies")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Allergy::query()->select(Allergy::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAllergy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAllergy $request)
    {
        try {
            $data = $request->sanitizedObject();
            $allergy = $this->repo::store($data);
            return $this->api->success()->message('Allergy Created')->payload($allergy)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Allergy $allergy
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Allergy $allergy)
    {
        try {
            $payload = $this->repo::init($allergy)->show($request);
            return $this->api->success()
                        ->message("Allergy $allergy->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAllergy $request
     * @param {$modelBaseName} $allergy
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAllergy $request, Allergy $allergy)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($allergy)->update($data);
            return $this->api->success()->message("Allergy has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Allergy $allergy
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyAllergy $request, Allergy $allergy)
    {
        $res = $this->repo::init($allergy)->destroy();
        return $this->api->success()->message("Allergy has been deleted")->payload($res)->code(200)->send();
    }

}

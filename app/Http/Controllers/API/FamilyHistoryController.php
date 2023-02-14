<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyHistory\IndexFamilyHistory;
use App\Http\Requests\FamilyHistory\StoreFamilyHistory;
use App\Http\Requests\FamilyHistory\UpdateFamilyHistory;
use App\Http\Requests\FamilyHistory\DestroyFamilyHistory;
use App\Models\FamilyHistory;
use App\Repositories\FamilyHistories;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class FamilyHistoryController  extends Controller
{
    private ApiResponse $api;
    private FamilyHistories $repo;
    public function __construct(ApiResponse $apiResponse, FamilyHistories $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexFamilyHistory $request)
    {
        $query = FamilyHistory::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of FamilyHistories")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = FamilyHistory::query()->select(FamilyHistory::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFamilyHistory $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFamilyHistory $request)
    {
        try {
            $data = $request->sanitizedObject();
            $familyHistory = $this->repo::store($data);
            return $this->api->success()->message('Family History Created')->payload($familyHistory)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param FamilyHistory $familyHistory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, FamilyHistory $familyHistory)
    {
        try {
            $payload = $this->repo::init($familyHistory)->show($request);
            return $this->api->success()
                        ->message("Family History $familyHistory->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFamilyHistory $request
     * @param {$modelBaseName} $familyHistory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFamilyHistory $request, FamilyHistory $familyHistory)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($familyHistory)->update($data);
            return $this->api->success()->message("Family History has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FamilyHistory $familyHistory
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyFamilyHistory $request, FamilyHistory $familyHistory)
    {
        $res = $this->repo::init($familyHistory)->destroy();
        return $this->api->success()->message("Family History has been deleted")->payload($res)->code(200)->send();
    }

}

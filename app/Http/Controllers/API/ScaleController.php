<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Scale\IndexScale;
use App\Http\Requests\Scale\StoreScale;
use App\Http\Requests\Scale\UpdateScale;
use App\Http\Requests\Scale\DestroyScale;
use App\Models\Scale;
use App\Repositories\Scales;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class ScaleController  extends Controller
{
    private ApiResponse $api;
    private Scales $repo;
    public function __construct(ApiResponse $apiResponse, Scales $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexScale $request)
    {
        $query = Scale::query(); // You can extend this however you want.
        $cols = [
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Scales")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Scale::query()->select(Scale::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreScale $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreScale $request)
    {
        try {
            $data = $request->sanitizedObject();
            $scale = $this->repo::store($data);
            return $this->api->success()->message('Scale Created')->payload($scale)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Scale $scale
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Scale $scale)
    {
        try {
            $payload = $this->repo::init($scale)->show($request);
            return $this->api->success()
                        ->message("Scale $scale->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateScale $request
     * @param {$modelBaseName} $scale
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateScale $request, Scale $scale)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($scale)->update($data);
            return $this->api->success()->message("Scale has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Scale $scale
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyScale $request, Scale $scale)
    {
        $res = $this->repo::init($scale)->destroy();
        return $this->api->success()->message("Scale has been deleted")->payload($res)->code(200)->send();
    }

}

<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChronicDisease\IndexChronicDisease;
use App\Http\Requests\ChronicDisease\StoreChronicDisease;
use App\Http\Requests\ChronicDisease\UpdateChronicDisease;
use App\Http\Requests\ChronicDisease\DestroyChronicDisease;
use App\Models\ChronicDisease;
use App\Repositories\ChronicDiseases;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class ChronicDiseaseController  extends Controller
{
    private ApiResponse $api;
    private ChronicDiseases $repo;
    public function __construct(ApiResponse $apiResponse, ChronicDiseases $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexChronicDisease $request)
    {
        $query = ChronicDisease::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of ChronicDiseases")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = ChronicDisease::query()->select(ChronicDisease::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreChronicDisease $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChronicDisease $request)
    {
        try {
            $data = $request->sanitizedObject();
            $chronicDisease = $this->repo::store($data);
            return $this->api->success()->message('Chronic Disease Created')->payload($chronicDisease)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param ChronicDisease $chronicDisease
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, ChronicDisease $chronicDisease)
    {
        try {
            $payload = $this->repo::init($chronicDisease)->show($request);
            return $this->api->success()
                        ->message("Chronic Disease $chronicDisease->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateChronicDisease $request
     * @param {$modelBaseName} $chronicDisease
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChronicDisease $request, ChronicDisease $chronicDisease)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($chronicDisease)->update($data);
            return $this->api->success()->message("Chronic Disease has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ChronicDisease $chronicDisease
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyChronicDisease $request, ChronicDisease $chronicDisease)
    {
        $res = $this->repo::init($chronicDisease)->destroy();
        return $this->api->success()->message("Chronic Disease has been deleted")->payload($res)->code(200)->send();
    }

}

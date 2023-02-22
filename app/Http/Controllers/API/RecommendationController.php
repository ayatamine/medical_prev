<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recommendation\IndexRecommendation;
use App\Http\Requests\Recommendation\StoreRecommendation;
use App\Http\Requests\Recommendation\UpdateRecommendation;
use App\Http\Requests\Recommendation\DestroyRecommendation;
use App\Models\Recommendation;
use App\Repositories\Recommendations;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class RecommendationController  extends Controller
{
    private ApiResponse $api;
    private Recommendations $repo;
    public function __construct(ApiResponse $apiResponse, Recommendations $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexRecommendation $request)
    {
        $query = Recommendation::query(); // You can extend this however you want.
        $cols = [
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Recommendations")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Recommendation::query()->select(Recommendation::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecommendation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRecommendation $request)
    {
        try {
            $data = $request->sanitizedObject();
            $recommendation = $this->repo::store($data);
            return $this->api->success()->message('Recommendation Created')->payload($recommendation)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Recommendation $recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Recommendation $recommendation)
    {
        try {
            $payload = $this->repo::init($recommendation)->show($request);
            return $this->api->success()
                        ->message("Recommendation $recommendation->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecommendation $request
     * @param {$modelBaseName} $recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRecommendation $request, Recommendation $recommendation)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($recommendation)->update($data);
            return $this->api->success()->message("Recommendation has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Recommendation $recommendation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyRecommendation $request, Recommendation $recommendation)
    {
        $res = $this->repo::init($recommendation)->destroy();
        return $this->api->success()->message("Recommendation has been deleted")->payload($res)->code(200)->send();
    }

}

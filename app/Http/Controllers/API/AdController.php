<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\IndexAd;
use App\Http\Requests\Ad\StoreAd;
use App\Http\Requests\Ad\UpdateAd;
use App\Http\Requests\Ad\DestroyAd;
use App\Models\Ad;
use App\Repositories\Ads;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class AdController  extends Controller
{
    private ApiResponse $api;
    private Ads $repo;
    public function __construct(ApiResponse $apiResponse, Ads $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexAd $request)
    {
        $query = Ad::query(); // You can extend this however you want.
        $cols = [
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Ads")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Ad::query()->select(Ad::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAd $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAd $request)
    {
        try {
            $data = $request->sanitizedObject();
            $ad = $this->repo::store($data);
            return $this->api->success()->message('Ad Created')->payload($ad)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Ad $ad
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Ad $ad)
    {
        try {
            $payload = $this->repo::init($ad)->show($request);
            return $this->api->success()
                        ->message("Ad $ad->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAd $request
     * @param {$modelBaseName} $ad
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAd $request, Ad $ad)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($ad)->update($data);
            return $this->api->success()->message("Ad has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ad $ad
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyAd $request, Ad $ad)
    {
        $res = $this->repo::init($ad)->destroy();
        return $this->api->success()->message("Ad has been deleted")->payload($res)->code(200)->send();
    }

}

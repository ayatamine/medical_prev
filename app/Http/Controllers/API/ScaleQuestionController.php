<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScaleQuestion\IndexScaleQuestion;
use App\Http\Requests\ScaleQuestion\StoreScaleQuestion;
use App\Http\Requests\ScaleQuestion\UpdateScaleQuestion;
use App\Http\Requests\ScaleQuestion\DestroyScaleQuestion;
use App\Models\ScaleQuestion;
use App\Repositories\ScaleQuestions;
use Illuminate\Http\Request;
use Savannabits\JetstreamInertiaGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class ScaleQuestionController  extends Controller
{
    private ApiResponse $api;
    private ScaleQuestions $repo;
    public function __construct(ApiResponse $apiResponse, ScaleQuestions $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexScaleQuestion $request)
    {
        $query = ScaleQuestion::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('question')->title('Question')->sort()->searchable(),
            Column::name('question_ar')->title('Question Ar')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of ScaleQuestions")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = ScaleQuestion::query()->select(ScaleQuestion::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreScaleQuestion $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreScaleQuestion $request)
    {
        try {
            $data = $request->sanitizedObject();
            $scaleQuestion = $this->repo::store($data);
            return $this->api->success()->message('Scale Question Created')->payload($scaleQuestion)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param ScaleQuestion $scaleQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, ScaleQuestion $scaleQuestion)
    {
        try {
            $payload = $this->repo::init($scaleQuestion)->show($request);
            return $this->api->success()
                        ->message("Scale Question $scaleQuestion->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateScaleQuestion $request
     * @param {$modelBaseName} $scaleQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateScaleQuestion $request, ScaleQuestion $scaleQuestion)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($scaleQuestion)->update($data);
            return $this->api->success()->message("Scale Question has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ScaleQuestion $scaleQuestion
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyScaleQuestion $request, ScaleQuestion $scaleQuestion)
    {
        $res = $this->repo::init($scaleQuestion)->destroy();
        return $this->api->success()->message("Scale Question has been deleted")->payload($res)->code(200)->send();
    }

}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recommendation\IndexRecommendation;
use App\Http\Requests\Recommendation\StoreRecommendation;
use App\Http\Requests\Recommendation\UpdateRecommendation;
use App\Http\Requests\Recommendation\DestroyRecommendation;
use App\Models\Recommendation;
use App\Repositories\Recommendations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class RecommendationController  extends Controller
{
    private Recommendations $repo;
    public function __construct(Recommendations $repo)
    {
        $this->repo = $repo;
    }

    /**
    * Display a listing of the resource.
    *
    * @param  Request $request
    * @return    \Inertia\Response
    * @throws  \Illuminate\Auth\Access\AuthorizationException
    */
    public function index(Request $request): \Inertia\Response
    {
        $this->authorize('viewAny', Recommendation::class);
        return Inertia::render('Recommendations/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Recommendation::class),
                "create" => \Auth::user()->can('create', Recommendation::class),
            ],
            "columns" => $this->repo::dtColumns(),
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return  \Inertia\Response
    */
    public function create()
    {
        $this->authorize('create', Recommendation::class);
        return Inertia::render("Recommendations/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Recommendation::class),
            "create" => \Auth::user()->can('create', Recommendation::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreRecommendation $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreRecommendation $request)
    {
        try {
            $data = $request->sanitizedObject();
            $recommendation = $this->repo::store($data);
            return back()->with(['success' => "The Recommendation was created succesfully."]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param Request $request
    * @param Recommendation $recommendation
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Recommendation $recommendation)
    {
        try {
            $this->authorize('view', $recommendation);
            $model = $this->repo::init($recommendation)->show($request);
            return Inertia::render("Recommendations/Show", ["model" => $model]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Show Edit Form for the specified resource.
    *
    * @param Request $request
    * @param Recommendation $recommendation
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Recommendation $recommendation)
    {
        try {
            $this->authorize('update', $recommendation);
            //Fetch relationships
            

                        return Inertia::render("Recommendations/Edit", ["model" => $recommendation]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Update the specified resource in storage.
    *
    * @param UpdateRecommendation $request
    * @param {$modelBaseName} $recommendation
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateRecommendation $request, Recommendation $recommendation)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($recommendation)->update($data);
            return back()->with(['success' => "The Recommendation was updated succesfully."]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param Recommendation $recommendation
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyRecommendation $request, Recommendation $recommendation)
    {
        $res = $this->repo::init($recommendation)->destroy();
        if ($res) {
            return back()->with(['success' => "The Recommendation was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The Recommendation could not be deleted."]);
        }
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChronicDisease\IndexChronicDisease;
use App\Http\Requests\ChronicDisease\StoreChronicDisease;
use App\Http\Requests\ChronicDisease\UpdateChronicDisease;
use App\Http\Requests\ChronicDisease\DestroyChronicDisease;
use App\Models\ChronicDisease;
use App\Repositories\ChronicDiseases;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class ChronicDiseaseController  extends Controller
{
    private ChronicDiseases $repo;
    public function __construct(ChronicDiseases $repo)
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
        $this->authorize('viewAny', ChronicDisease::class);
        return Inertia::render('ChronicDiseases/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', ChronicDisease::class),
                "create" => \Auth::user()->can('create', ChronicDisease::class),
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
        $this->authorize('create', ChronicDisease::class);
        return Inertia::render("ChronicDiseases/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', ChronicDisease::class),
            "create" => \Auth::user()->can('create', ChronicDisease::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreChronicDisease $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreChronicDisease $request)
    {
        try {
            $data = $request->sanitizedObject();
            $chronicDisease = $this->repo::store($data);
            return back()->with(['success' => "The Chronic Disease was created succesfully."]);
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
    * @param ChronicDisease $chronicDisease
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, ChronicDisease $chronicDisease)
    {
        try {
            $this->authorize('view', $chronicDisease);
            $model = $this->repo::init($chronicDisease)->show($request);
            return Inertia::render("ChronicDiseases/Show", ["model" => $model]);
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
    * @param ChronicDisease $chronicDisease
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, ChronicDisease $chronicDisease)
    {
        try {
            $this->authorize('update', $chronicDisease);
            //Fetch relationships
            

                        return Inertia::render("ChronicDiseases/Edit", ["model" => $chronicDisease]);
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
    * @param UpdateChronicDisease $request
    * @param {$modelBaseName} $chronicDisease
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateChronicDisease $request, ChronicDisease $chronicDisease)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($chronicDisease)->update($data);
            return back()->with(['success' => "The ChronicDisease was updated succesfully."]);
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
    * @param ChronicDisease $chronicDisease
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyChronicDisease $request, ChronicDisease $chronicDisease)
    {
        $res = $this->repo::init($chronicDisease)->destroy();
        if ($res) {
            return back()->with(['success' => "The ChronicDisease was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The ChronicDisease could not be deleted."]);
        }
    }
}

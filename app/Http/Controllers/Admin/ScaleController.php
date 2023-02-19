<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Scale\IndexScale;
use App\Http\Requests\Scale\StoreScale;
use App\Http\Requests\Scale\UpdateScale;
use App\Http\Requests\Scale\DestroyScale;
use App\Models\Scale;
use App\Repositories\Scales;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class ScaleController  extends Controller
{
    private Scales $repo;
    public function __construct(Scales $repo)
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
        $this->authorize('viewAny', Scale::class);
        return Inertia::render('Scales/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Scale::class),
                "create" => \Auth::user()->can('create', Scale::class),
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
        $this->authorize('create', Scale::class);
        return Inertia::render("Scales/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Scale::class),
            "create" => \Auth::user()->can('create', Scale::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreScale $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreScale $request)
    {
        try {
            $data = $request->sanitizedObject();
            $scale = $this->repo::store($data);
            return back()->with(['success' => "The Scale was created succesfully."]);
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
    * @param Scale $scale
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Scale $scale)
    {
        try {
            $this->authorize('view', $scale);
            $model = $this->repo::init($scale)->show($request);
            return Inertia::render("Scales/Show", ["model" => $model]);
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
    * @param Scale $scale
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Scale $scale)
    {
        try {
            $this->authorize('update', $scale);
            //Fetch relationships
            

                        return Inertia::render("Scales/Edit", ["model" => $scale]);
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
    * @param UpdateScale $request
    * @param {$modelBaseName} $scale
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateScale $request, Scale $scale)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($scale)->update($data);
            return back()->with(['success' => "The Scale was updated succesfully."]);
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
    * @param Scale $scale
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyScale $request, Scale $scale)
    {
        $res = $this->repo::init($scale)->destroy();
        if ($res) {
            return back()->with(['success' => "The Scale was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The Scale could not be deleted."]);
        }
    }
}

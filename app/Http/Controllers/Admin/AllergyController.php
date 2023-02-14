<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Allergy\IndexAllergy;
use App\Http\Requests\Allergy\StoreAllergy;
use App\Http\Requests\Allergy\UpdateAllergy;
use App\Http\Requests\Allergy\DestroyAllergy;
use App\Models\Allergy;
use App\Repositories\Allergies;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class AllergyController  extends Controller
{
    private Allergies $repo;
    public function __construct(Allergies $repo)
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
        $this->authorize('viewAny', Allergy::class);
        return Inertia::render('Allergies/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Allergy::class),
                "create" => \Auth::user()->can('create', Allergy::class),
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
        $this->authorize('create', Allergy::class);
        return Inertia::render("Allergies/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Allergy::class),
            "create" => \Auth::user()->can('create', Allergy::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreAllergy $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreAllergy $request)
    {
        try {
            $data = $request->sanitizedObject();
            $allergy = $this->repo::store($data);
            return back()->with(['success' => "The Allergy was created succesfully."]);
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
    * @param Allergy $allergy
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Allergy $allergy)
    {
        try {
            $this->authorize('view', $allergy);
            $model = $this->repo::init($allergy)->show($request);
            return Inertia::render("Allergies/Show", ["model" => $model]);
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
    * @param Allergy $allergy
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Allergy $allergy)
    {
        try {
            $this->authorize('update', $allergy);
            //Fetch relationships
            

                        return Inertia::render("Allergies/Edit", ["model" => $allergy]);
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
    * @param UpdateAllergy $request
    * @param {$modelBaseName} $allergy
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateAllergy $request, Allergy $allergy)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($allergy)->update($data);
            return back()->with(['success' => "The Allergy was updated succesfully."]);
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
    * @param Allergy $allergy
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyAllergy $request, Allergy $allergy)
    {
        $res = $this->repo::init($allergy)->destroy();
        if ($res) {
            return back()->with(['success' => "The Allergy was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The Allergy could not be deleted."]);
        }
    }
}

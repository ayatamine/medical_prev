<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\FamilyHistory\IndexFamilyHistory;
use App\Http\Requests\FamilyHistory\StoreFamilyHistory;
use App\Http\Requests\FamilyHistory\UpdateFamilyHistory;
use App\Http\Requests\FamilyHistory\DestroyFamilyHistory;
use App\Models\FamilyHistory;
use App\Repositories\FamilyHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class FamilyHistoryController  extends Controller
{
    private FamilyHistories $repo;
    public function __construct(FamilyHistories $repo)
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
        $this->authorize('viewAny', FamilyHistory::class);
        return Inertia::render('FamilyHistories/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', FamilyHistory::class),
                "create" => \Auth::user()->can('create', FamilyHistory::class),
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
        $this->authorize('create', FamilyHistory::class);
        return Inertia::render("FamilyHistories/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', FamilyHistory::class),
            "create" => \Auth::user()->can('create', FamilyHistory::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreFamilyHistory $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreFamilyHistory $request)
    {
        try {
            $data = $request->sanitizedObject();
            $familyHistory = $this->repo::store($data);
            return back()->with(['success' => "The Family History was created succesfully."]);
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
    * @param FamilyHistory $familyHistory
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, FamilyHistory $familyHistory)
    {
        try {
            $this->authorize('view', $familyHistory);
            $model = $this->repo::init($familyHistory)->show($request);
            return Inertia::render("FamilyHistories/Show", ["model" => $model]);
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
    * @param FamilyHistory $familyHistory
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, FamilyHistory $familyHistory)
    {
        try {
            $this->authorize('update', $familyHistory);
            //Fetch relationships
            

                        return Inertia::render("FamilyHistories/Edit", ["model" => $familyHistory]);
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
    * @param UpdateFamilyHistory $request
    * @param {$modelBaseName} $familyHistory
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateFamilyHistory $request, FamilyHistory $familyHistory)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($familyHistory)->update($data);
            return back()->with(['success' => "The FamilyHistory was updated succesfully."]);
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
    * @param FamilyHistory $familyHistory
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyFamilyHistory $request, FamilyHistory $familyHistory)
    {
        $res = $this->repo::init($familyHistory)->destroy();
        if ($res) {
            return back()->with(['success' => "The FamilyHistory was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The FamilyHistory could not be deleted."]);
        }
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatientScale\IndexPatientScale;
use App\Http\Requests\PatientScale\StorePatientScale;
use App\Http\Requests\PatientScale\UpdatePatientScale;
use App\Http\Requests\PatientScale\DestroyPatientScale;
use App\Models\PatientScale;
use App\Repositories\PatientScales;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class PatientScaleController  extends Controller
{
    private PatientScales $repo;
    public function __construct(PatientScales $repo)
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
        $this->authorize('viewAny', PatientScale::class);
        return Inertia::render('PatientScales/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', PatientScale::class),
                "create" => \Auth::user()->can('create', PatientScale::class),
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
        $this->authorize('create', PatientScale::class);
        return Inertia::render("PatientScales/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', PatientScale::class),
            "create" => \Auth::user()->can('create', PatientScale::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StorePatientScale $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StorePatientScale $request)
    {
        try {
            $data = $request->sanitizedObject();
            $patientScale = $this->repo::store($data);
            return back()->with(['success' => "The Patient Scale was created succesfully."]);
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
    * @param PatientScale $patientScale
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, PatientScale $patientScale)
    {
        try {
            $this->authorize('view', $patientScale);
            $model = $this->repo::init($patientScale)->show($request);
            return Inertia::render("PatientScales/Show", ["model" => $model]);
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
    * @param PatientScale $patientScale
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, PatientScale $patientScale)
    {
        try {
            $this->authorize('update', $patientScale);
            //Fetch relationships
            



        $patientScale->load([
            'patient',
            'scale',
        ]);
                        return Inertia::render("PatientScales/Edit", ["model" => $patientScale]);
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
    * @param UpdatePatientScale $request
    * @param {$modelBaseName} $patientScale
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdatePatientScale $request, PatientScale $patientScale)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($patientScale)->update($data);
            return back()->with(['success' => "The PatientScale was updated succesfully."]);
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
    * @param PatientScale $patientScale
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyPatientScale $request, PatientScale $patientScale)
    {
        $res = $this->repo::init($patientScale)->destroy();
        if ($res) {
            return back()->with(['success' => "The PatientScale was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The PatientScale could not be deleted."]);
        }
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\IndexPatient;
use App\Http\Requests\Patient\StorePatient;
use App\Http\Requests\Patient\UpdatePatient;
use App\Http\Requests\Patient\DestroyPatient;
use App\Models\Patient;
use App\Repositories\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class PatientController  extends Controller
{
    private Patients $repo;
    public function __construct(Patients $repo)
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
        $this->authorize('viewAny', Patient::class);
        return Inertia::render('Patients/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Patient::class),
                "create" => \Auth::user()->can('create', Patient::class),
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
        $this->authorize('create', Patient::class);
        return Inertia::render("Patients/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Patient::class),
            "create" => \Auth::user()->can('create', Patient::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StorePatient $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StorePatient $request)
    {
        try {
            $data = $request->sanitizedObject();
            $patient = $this->repo::store($data);
            return back()->with(['success' => "The Patient was created succesfully."]);
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
    * @param Patient $patient
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Patient $patient)
    {
        try {
            $this->authorize('view', $patient);
            $model = $this->repo::init($patient)->show($request);
            return Inertia::render("Patients/Show", ["model" => $model]);
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
    * @param Patient $patient
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Patient $patient)
    {
        try {
            $this->authorize('update', $patient);
            //Fetch relationships
            



        $patient->load([
            'chronicDisease',
            'allergy',
            'familyHistory',
        ]);
                        return Inertia::render("Patients/Edit", ["model" => $patient]);
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
    * @param UpdatePatient $request
    * @param {$modelBaseName} $patient
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdatePatient $request, Patient $patient)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($patient)->update($data);
            return back()->with(['success' => "The Patient was updated succesfully."]);
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
    * @param Patient $patient
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyPatient $request, Patient $patient)
    {
        $res = $this->repo::init($patient)->destroy();
        if ($res) {
            return back()->with(['success' => "The Patient was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The Patient could not be deleted."]);
        }
    }
}

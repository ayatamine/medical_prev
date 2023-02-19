<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScaleQuestion\IndexScaleQuestion;
use App\Http\Requests\ScaleQuestion\StoreScaleQuestion;
use App\Http\Requests\ScaleQuestion\UpdateScaleQuestion;
use App\Http\Requests\ScaleQuestion\DestroyScaleQuestion;
use App\Models\ScaleQuestion;
use App\Repositories\ScaleQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class ScaleQuestionController  extends Controller
{
    private ScaleQuestions $repo;
    public function __construct(ScaleQuestions $repo)
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
        $this->authorize('viewAny', ScaleQuestion::class);
        return Inertia::render('ScaleQuestions/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', ScaleQuestion::class),
                "create" => \Auth::user()->can('create', ScaleQuestion::class),
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
        $this->authorize('create', ScaleQuestion::class);
        return Inertia::render("ScaleQuestions/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', ScaleQuestion::class),
            "create" => \Auth::user()->can('create', ScaleQuestion::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreScaleQuestion $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreScaleQuestion $request)
    {
        try {
            $data = $request->sanitizedObject();
            $scaleQuestion = $this->repo::store($data);
            return back()->with(['success' => "The Scale Question was created succesfully."]);
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
    * @param ScaleQuestion $scaleQuestion
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, ScaleQuestion $scaleQuestion)
    {
        try {
            $this->authorize('view', $scaleQuestion);
            $model = $this->repo::init($scaleQuestion)->show($request);
            return Inertia::render("ScaleQuestions/Show", ["model" => $model]);
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
    * @param ScaleQuestion $scaleQuestion
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, ScaleQuestion $scaleQuestion)
    {
        try {
            $this->authorize('update', $scaleQuestion);
            //Fetch relationships
            



        $scaleQuestion->load([
            'scale',
        ]);
                        return Inertia::render("ScaleQuestions/Edit", ["model" => $scaleQuestion]);
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
    * @param UpdateScaleQuestion $request
    * @param {$modelBaseName} $scaleQuestion
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateScaleQuestion $request, ScaleQuestion $scaleQuestion)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($scaleQuestion)->update($data);
            return back()->with(['success' => "The ScaleQuestion was updated succesfully."]);
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
    * @param ScaleQuestion $scaleQuestion
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyScaleQuestion $request, ScaleQuestion $scaleQuestion)
    {
        $res = $this->repo::init($scaleQuestion)->destroy();
        if ($res) {
            return back()->with(['success' => "The ScaleQuestion was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The ScaleQuestion could not be deleted."]);
        }
    }
}

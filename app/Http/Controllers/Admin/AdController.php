<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\IndexAd;
use App\Http\Requests\Ad\StoreAd;
use App\Http\Requests\Ad\UpdateAd;
use App\Http\Requests\Ad\DestroyAd;
use App\Models\Ad;
use App\Repositories\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class AdController  extends Controller
{
    private Ads $repo;
    public function __construct(Ads $repo)
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
        $this->authorize('viewAny', Ad::class);
        return Inertia::render('Ads/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Ad::class),
                "create" => \Auth::user()->can('create', Ad::class),
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
        $this->authorize('create', Ad::class);
        return Inertia::render("Ads/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Ad::class),
            "create" => \Auth::user()->can('create', Ad::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreAd $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreAd $request)
    {
        try {
            $data = $request->sanitizedObject();
            $ad = $this->repo::store($data);
            return back()->with(['success' => "The Ad was created succesfully."]);
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
    * @param Ad $ad
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Ad $ad)
    {
        try {
            $this->authorize('view', $ad);
            $model = $this->repo::init($ad)->show($request);
            return Inertia::render("Ads/Show", ["model" => $model]);
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
    * @param Ad $ad
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Ad $ad)
    {
        try {
            $this->authorize('update', $ad);
            //Fetch relationships
            

                        return Inertia::render("Ads/Edit", ["model" => $ad]);
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
    * @param UpdateAd $request
    * @param {$modelBaseName} $ad
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateAd $request, Ad $ad)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($ad)->update($data);
            return back()->with(['success' => "The Ad was updated succesfully."]);
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
    * @param Ad $ad
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyAd $request, Ad $ad)
    {
        $res = $this->repo::init($ad)->destroy();
        if ($res) {
            return back()->with(['success' => "The Ad was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The Ad could not be deleted."]);
        }
    }
}

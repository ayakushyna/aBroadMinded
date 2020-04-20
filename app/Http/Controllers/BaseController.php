<?php


namespace App\Http\Controllers;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $baseRepository;
    protected $name;
    protected $validateRequest;

    /**
     * BaseController constructor.
     * @param String $name
     * @param BaseRepositoryInterface $baseRepository
     */
    public function __construct(String $name, BaseRepositoryInterface $baseRepository)
    {
        $this->name = $name;
        $this->baseRepository = $baseRepository;
    }

    public function index()
    {
        $records = $this->baseRepository->all();
        //return view("$this->name.index", compact(['records']));
        return response()->json([
            'data' => $records
        ], 200);
    }

    public function store(Request $request)
    {
        app($this->validateRequest);
        $this->baseRepository->create($request->only($this->baseRepository->getModel()->fillable));
        return redirect(route("$this->name.index"));
    }

    public function show($id)
    {
        return view("$this->name.show", compact([
            'record' => $this->baseRepository->findById($id)
        ]));
    }

    public function update(Request $request,$id)
    {
        app($this->validateRequest);
        $this->baseRepository->update($request->only($this->baseRepository->getModel()->fillable), $id);
        return redirect(route("$this->name.index"));
    }

    public function destroy($id)
    {
        $this->baseRepository->delete($id);
        return redirect(route("$this->name.index"));
    }
}

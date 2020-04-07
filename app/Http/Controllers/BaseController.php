<?php


namespace App\Http\Controllers;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    private $baseRepository;
    private $name;

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
        return view("$this->name.index", compact(['records']));
    }

    public function create()
    {
        return view("$this->name.create");
    }

    public function store(Request $request)
    {
        $this->baseRepository->create($request->only($this->baseRepository->getModel()->fillable));
        return redirect(route("$this->name.index"));
    }

    public function show($id)
    {
        return view("$this->name.show", compact([
            'record' => $this->baseRepository->findById($id)
        ]));
    }

    public function edit($id)
    {
        return view("$this->name.edit", compact([
            'record' => $this->baseRepository->findById($id)
        ]));
    }

    public function update(Request $request,$id)
    {
        $this->baseRepository->update($request->only($this->baseRepository->getModel()->fillable), $id);
        return redirect(route("$this->name.index"));
    }

    public function destroy($id)
    {
        $this->baseRepository->delete($id);
        return redirect(route("$this->name.index"));
    }
}

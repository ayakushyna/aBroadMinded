<?php


namespace App\Http\Controllers;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected BaseRepositoryInterface $baseRepository;
    protected string $name;
    protected string $validateRequest;

    public function __construct(BaseRepositoryInterface $baseRepository)
    {
        $this->baseRepository = $baseRepository ;
    }

    public function index()
    {
        $data = $this->baseRepository->all();

        $fields = [
            'primary_fields' =>  $this->baseRepository->getPrimaryFields(),
            'secondary_fields' => $this->baseRepository->getSecondaryFields()
        ];

        $data = $data->toArray();
        $items = $data['data'];

        unset($data['data']);
        $pagination = $data;

        return response()->json([
            'name' => $this->name,
            'items' => $items,
            'pagination' => $pagination,
            'fields' => $fields
        ], 200);
    }

    public function store(Request $request)
    {
        app($this->validateRequest);

        return response()->json([
            'items' => $this->baseRepository->create($request->only($this->baseRepository->getModel()->fillable))
        ], 200);
    }

    public function show($id)
    {
        $data = $this->baseRepository->findById($id);

        return response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function update(Request $request,$id)
    {
        app($this->validateRequest);

        return $this->baseRepository->update($request->only($this->baseRepository->getModel()->fillable), $id);
    }

    public function destroy($id)
    {
        $this->baseRepository->delete($id);
    }
}

<?php


namespace App\Http\Controllers;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    protected BaseRepositoryInterface $baseRepository;
    protected string $name;
    protected string $validateRequest;

    public function __construct(BaseRepositoryInterface $baseRepository)
    {
        $this->baseRepository = $baseRepository ;
    }

    public function index(Request $request)
    {
        $params = $this->toArray($request);

        $data = $this->baseRepository->all($params['filters'], $params['sortings']);

        $fields = $this->baseRepository->getFieldsInfo();

        $data = $data->toArray();
        $items = $data['data'];

        unset($data['data']);
        $pagination = $data;

        return response()->json([
            'items' => $items,
            'pagination' => $pagination,
            'fields' => $fields,
            'params' => $params,
        ], 200);
    }

    public function toArray(Request $request)
    {
        return [
            'filters' => json_decode($request->filters, true)?? [],
            'sortings' => json_decode($request->sortings, true)?? []
        ];
    }

    public function store(Request $request)
    {
        app($this->validateRequest);

        return response()->json([
            'items' => $this->baseRepository->create($request->only($this->baseRepository->getModel()->getFillable()))
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

        return $this->baseRepository->update($request->only($this->baseRepository->getModel()->getFillable()), $id);
    }

    public function destroy($id)
    {
        $this->baseRepository->delete($id);
    }
}

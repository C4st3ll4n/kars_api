<?php
namespace App\Repositories;
use App\Models\Cars;
use Illuminate\Http\Request;

class CarRepositoryEloquent implements  ICarRepository
{

    private $model;

    /**
     * CarRepositoryEloquent constructor.
     * @param Cars $cars
     */
    public function __construct(Cars $cars)
    {
        $this->model = $cars;
    }

    function getAll()
    {
        return $this->model->all();
    }

    function get($id)
    {
        return $this->model->find($id);
    }

    function destroy($id)
    {
        return $this->model->find($id)->delete();
    }

    function update($id, Request $request)
    {
        return $this->model->find($id)->update($request->all());
    }

    function store(Request $request)
    {
        return $this->model->create($request->all());
    }
}

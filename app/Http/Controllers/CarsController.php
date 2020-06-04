<?php
namespace App\Http\Controllers;
use App\Services\CarsService;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(CarsService $cars)
    {
        $this->service = $cars;
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

    public function update($id, Request $request)
    {
        return $this->service->update($id, $request);
    }

    public function get($id)
    {
        return $this->service->get($id);
    }

    public function getAll()
    {
        return $this->service->getAll();
    }

}

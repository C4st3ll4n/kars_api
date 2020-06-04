<?php
namespace App\Services;
use App\Models\Cars;
use App\Models\ValidationCars;
use App\Repositories\ICarRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CarsService
{

    private $repository;

    public function __construct(ICarRepository $repo)
    {

        $this->repository = $repo;
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ValidationCars::RULE_CAR
        );

        $resp = [];

        if ($validator->fails()) {
            $code = Response::HTTP_BAD_REQUEST;
            $resp = ["msg" => "Falha !", "code" => $code, "data" => $validator->errors(), "num_cars" => 0];
        } else {

            try {

                $car = $this->repository->store($request);
                $code = 0;

                if ($car != null) {
                    $code = Response::HTTP_CREATED;
                    $resp = ["msg" => "Sucesso !", "code" => $code, "data" => $car, "num_cars" => 1];
                } else {
                    $code = Response::HTTP_CONFLICT;
                    $resp = ["msg" => "Falha ao criar !", "code" => $code, "data" => [], "num_cars" => 0];
                }

            } catch (QueryException $exception) {

                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                $resp = ["msg" => "Sucesso !", "code" => $code, "data" => [], "num_cars" => 0];

            }
        }

        return response()->json($resp, $code);
    }

    public function destroy($id)
    {
        $resp = [];
        $code = 0;
        try {
            $car = $this->repository->destroy($id);

            $cars = $this->repository->getAll();
            $code = Response::HTTP_OK;
            $resp = ["msg" => "Sucesso !", "code" => $code, "data" => $cars, "num_cars" => count($cars)];
        } catch (QueryException $exception) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $resp = ["msg" => "Falha nossa !", "code" => $code, "data" => [], "num_cars" => 0];
        }

        return response()->json($resp, $code);
    }

    public function update($id, Request $request)
    {
        $car = $this->repository->update($id, $request);

        $resp = ["msg" => "Sucesso !", "code" => Response::HTTP_OK, "data" => $car, "num_cars" => 1];


        return response()->json($resp);
    }

    public function get($id)
    {
        $resp = [];
        $code = 0;
        try {
            $car = $this->repository->get($id);

            $resp = [];
            if ($car != null) {
                $code = Response::HTTP_OK;
                $resp = ["msg" => "Sucesso !", "code" => $code, "data" => $car, "num_cars" => 1];

            } else {
                $code = Response::HTTP_NOT_FOUND;

                $resp = ["msg" => "Nenhum carro encontrado !", "code" => $code, "data" => [], "num_cars" => 0];
            }

        } catch (QueryException $exception) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $resp = ["msg" => "Falha nossa !", "code" => $code, "data" => [], "num_cars" => 0];
        }

        return response()->json($resp, $code);
    }

    public function getAll()
    {
        $resp = [];
        $code = 0;

        try {

            $cars = $this->repository->getAll();
            $qtdCars = count($cars);
            $resp = [];
            if ($qtdCars > 0) {
                $code = Response::HTTP_OK;
                    $resp = ["msg" => "Sucesso !", "code" => $code, "data" => $cars, "num_cars" => $qtdCars];
            } else {
                $code = Response::HTTP_NOT_FOUND;
                $resp = ["msg" => "Nenhum carro cadastrado !", "code" => $code, "data" => [], "num_cars" => 0];
            }

        } catch (QueryException $exception) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $resp = ["msg" => "Falha nossa", "code" => $code, "data" => [], "num_cars" => 0];
        }

        return response()->json($resp, $code);
    }

}

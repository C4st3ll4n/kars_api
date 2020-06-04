<?php
namespace App\Repositories;
use Illuminate\Http\Request;

interface ICarRepository
{
    function getAll();
    function get($id);
    function destroy($id);
    function update($id, Request $request);
    function store(Request $request);
}

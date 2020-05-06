<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Breadcrumbs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Response in json
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function responseInJson($data)
    {
        return response()->json($data);
    }
}

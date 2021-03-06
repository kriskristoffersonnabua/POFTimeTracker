<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Breadcrumbs;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

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

    /**
     * Get user
     *
     * @param  Request $request
     *
     * @return App\User
     *
     * @throws AuthenticationException
     */
    protected function getAuthenticatedUser(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            // throw new AuthenticationException('Unauthenticated.', 401);
            return redirect()->guest(route('/'));
        }
        
        return $user;
    }

    protected function requestAPI( $link, $method = 'GET', $filters = []) {
        $request = Request::create($link, $method, array_merge([
            'headers' => [
                'Accept'        => 'application/json'
            ],
        ], $filters));

        $response = json_decode(Route::dispatch($request)->getContent());

        return $response;
    }
}

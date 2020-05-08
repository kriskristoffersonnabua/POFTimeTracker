<?php

namespace App\Http\Controllers\Api\Activities;

use App\Models\Activities\ActivityFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use DB;
use App\Traits\ApiHelper;

class ActivityFilesController extends Controller
{
    use ApiHelper;

    public function index(Request $request) {
        try {
            $filters = [];
            
            $query = $this->buildQuery($filters);
            
            $count = $query->count();

            return $this->sendResponse(['activity_files' => $query->get()->toArray(), 'count' => $count], "Activity File/s");

        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'No Activity Files',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store() {

    }

    public function update() {

    }

    public function delete() {

    }

    protected function buildQuery($filters) {        
        $dateFields = ['created_at', 'updated_at'];

        $query = app(ActivityFile::class);
        foreach ($filters as $key => $value) {
            if (in_array($key, $dateFields)) {
                if (count($value) == 1) {
                    extract($this->convertDateFormat($value)[0]);
                    $query = $query->whereRaw(DB::raw("$key $comparison ?"));
                    $bindings[] = $date;
                } elseif (count($value) == 2) {
                    $query = $query->whereRaw(DB::raw("($key BETWEEN ? AND ?)"));
                    $bindings[] = $value[0];
                    $bindings[] = $value[1];
                }
                $query = $query->addBinding($bindings, 'where');
            } elseif (is_array($value)) {
                $query = $query->whereIn($key, $value);
            } elseif (is_int($value)) {
                $query = $query->where($key, $value);
            } else {
                $query = $query->whereRaw(DB::raw("$key LIKE ?"));
                $query = $query->addBinding("%$value%", 'where');
            }
        }
        return $query;
    }
}
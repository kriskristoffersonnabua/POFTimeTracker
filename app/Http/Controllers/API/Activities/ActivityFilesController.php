<?php

namespace App\Http\Controllers\Api\Activities;

use App\Traits\DataConverterHelper;
use App\Models\Activities\ActivityFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Carbon\Carbon;
use DB;
use App\Traits\ApiHelper;

class ActivityFilesController extends Controller
{
    use ApiHelper, DataConverterHelper;

    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT  = 10;

    public function index(Request $request) {
        try {
            $filters = [
                'id'    => $this->convertCommaSeparated($request->get('id')),
                'activity_id'  =>  $this->convertCommaSeparated($request->get('activity_id')),
            ];
            $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
            $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);
            
            $count = $query->count();

            $query = $query->offset($offset);
            $query = $query->limit($limit);
            
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

    public function store(Request $request) {
        try {
            $request->validate([
                'activity_id'   => 'required',
                'file'  => 'required',
                'file_link' => 'required'
            ]);

            $activity_id = $request->get('activity_id');
            $file = $request->get('file');
            $file_link  = $request->get('file_link');

            $activity_file = new ActivityFile;
            $activity_file->activity_id = $activity_id;
            $activity_file->file = null;
            $activity_file->file_link = $file_link;
            $activity_file->date_added = Carbon::now();
            $activity_file->created_at = Carbon::now();
            $activity_file->updated_at = Carbon::now();

            $activity_file->save();

            return $this->sendResponse($activity_file->toArray(), "Activity File created.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity File could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function show(Request $request, $id) {
        try {
            $activity_file = app(ActivityFile::class)->findOrFail($id);

            return $this->sendResponse($activity_file->toArray(), "Activity File found.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity File could not be found',
                ['error' => $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = [
                'activity_id'   => $request->get('activity_id'),
                'file'  => $request->get('file'),
                'file_link' => $request->get('file_link')
            ];

            $activity_file = app(ActivityFile::class)->findOrFail($id);
            $activity_file->fill($data);
            $activity_file->save();

            return $this->sendResponse($activity_file->toArray(), "Activity File updated.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity File could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function delete(Request $request, $id) {
        try{
            $activity_file = app(ActivityFile::class)->findOrFail($id);

            $activity_file->delete();
              
            return $this->sendResponse(['is_deleted' => true], "Activity File deleted");
                
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity File could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
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
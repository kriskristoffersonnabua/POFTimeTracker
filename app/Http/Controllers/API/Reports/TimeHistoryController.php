<?php

namespace App\Http\Controllers\API\Reports;

use App\Http\Controllers\Controller;
use App\Models\Reports\TimeHistory;
use App\Traits\ApiHelper;
use App\Traits\DataConverterHelper;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use lluminate\Routing\ResponseFactory;

class TimeHistoryController extends Controller
{
    use ApiHelper, DataConverterHelper;
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

    public function index(Request $request) {
        try {
            $filters = [
                'id'            => $this->convertCommaSeparated($request->get('id')),
                'user_id'       => $this->convertCommaSeparated($request->get('user_id')),
                'activity_id'   => $this->convertCommaSeparated($request->get('activity_id')),
                'project_id'    => $this->convertCommaSeparated($request->get('project_id')),
                'subproject_id' => $this->convertCommaSeparated($request->get('subproject_id')),
                'date'          => $this->convertDateRange($request->get('date')),
                'time_start'    => $this->convertDate($request->get('time_start')),
                'time_end'      => $this->convertDate($request->get('time_end'))
            ];
            $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
            $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);

            $count = $query->count();

            $query = $query->offset($offset);
            $query = $query->limit($limit);

            return $this->sendResponse(['time_history' => $query->get()->toArray(), 'count' => $count], "Time Histories fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Time histories could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function count(Request $request) {
        try {
            $filters = [
                'id'            => $this->convertCommaSeparated($request->get('id')),
                'user_id'       => $this->convertCommaSeparated($request->get('user_id')),
                'activity_id'   => $this->convertCommaSeparated($request->get('activity_id')),
                'project_id'    => $this->convertCommaSeparated($request->get('project_id')),
                'subproject_id' => $this->convertCommaSeparated($request->get('subproject_id')),
                'date'          => $this->convertDateRange($request->get('date')),
                'time_start'    => Carbon::parse($request->get('time_start'))->toTimeString(),
                'time_end'      => Carbon::parse($request->get('time_end'))->toTimeString()
            ];
    
            $filters = array_remove_null($filters);
            $query = $this->buildQuery($filters);

            return $this->sendResponse(['count' => $query->count()], "Time Histories count fetched.");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Time Histories count could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function show(Request $request, $id) {
        try {
            $timeHistory = app(TimeHistory::class)->findOrFail($id);

            return $this->sendResponse($timeHistory->toArray(), "Time History found.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Time History could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'user_id' => 'required',
                'activity_id' => 'required'
            ]);

            $date_now = Carbon::now();

            $user_id = $request->get('user_id');
            $activity_id = $request->get('activity_id');

            $timeHistory = new TimeHistory;
            $timeHistory->user_id = $user_id;
            $timeHistory->activity_id = $activity_id;
            $timeHistory->date = $date_now->toDateString(); ;
            $timeHistory->time_start = $date_now;
            $timeHistory->created_at = $date_now;
            $timeHistory->updated_at = $date_now;
            $timeHistory->save();

            return $this->sendResponse($timeHistory->toArray(), "Time history created.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Time history could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function destroy(Request $request, $id) {
        try{
            $timeHistory = app(TimeHistory::class)->findOrFail($id);
            if ($timeHistory->delete()) {
                return $this->sendResponse(['is_deleted' => true], "Time History deleted");
            }
            throw new \Exception("Internal server error");

        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Time History could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
    
    public function update(Request $request, $id) {
        try {
            $hms = explode(":", $request->get('time_consumed'));
            $time_consumed = ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));

            $data = [
                'time_end'      => Carbon::now(),
                'time_consumed' => $time_consumed
            ];

            $timeHistory = app(TimeHistory::class)->findOrFail($id);
            $timeHistory->fill(array_remove_null($data));
            $timeHistory->save();

            return $this->sendResponse($timeHistory->toArray(), "Time History updated.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Time History could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    protected function buildQuery($filters) {        
        $dateFields = ['date', 'time_start', 'time_end'];
        $query = app(TimeHistory::class);
        if (in_array('project_id', array_keys($filters)) || in_array('subproject_id', array_keys($filters))) {
            $query = $query->joinProjectAndSubproject($query);
        }
        foreach ($filters as $key => $value) {
            if ($key == 'project_id') {
                $query = $query->where('projects.id', $value);
            } elseif ($key == 'subproject_id') {
                $query = $query->where('subprojects.id', $value);
            } elseif (in_array($key, $dateFields)) {
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
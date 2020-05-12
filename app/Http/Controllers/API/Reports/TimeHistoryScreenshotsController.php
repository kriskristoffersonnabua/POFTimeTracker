<?php

namespace App\Http\Controllers\API\Reports;

use App\Models\Reports\Screenshots;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\ApiHelper;

class TimeHistoryScreenshotsController extends Controller
{
    use ApiHelper;

    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10; 

    public function index(Request $request) {
        try {
            $params = $request->all();
            $query = null;

            if (array_key_exists('time_history_id', $params)) {
                $query = Screenshots::where('time_history_id', $params['time_history_id']);
            }

            if (isset($query)) {
                $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
                $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;
                $query = $query->offset($offset);
                $query = $query->limit($limit);

                $response = $query->get()->toArray();
                foreach($response as $idx => $screenshot) {
                    unset($response[$idx]['screenshot']);
                }
                return $this->sendResponse($response, "Project/s fetched.");
            } else {
                throw new \Exception('Query not supported', 422);
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Screenshots/s could not be fetched',
                ['error'=> $e->getMessage(), 'line' => $e->getLine()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function show(Request $request) {
        try {
            $id = $request->get('id');
            $screenshot = Screenshots::find($id)->toArray();

            return response()->json(stream_get_contents( $screenshot['screenshot'] ));
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'screenshot could not be fetched',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->all();

            $screenshot = new Screenshots;
            $screenshot->time_history_id = $data['time_history_id'];
            $screenshot->screenshot = $data['screenshot'];
            $screenshot->date_added = $data['date_added'];
            $screenshot->save();

            return $this->sendResponse($screenshot->toArray(), "screenshot created.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'screenshot could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->all();

            $screenshot = app(Screenshots::class)->find($id);
            $screenshot->update($data);
            $screenshot->save();
            
            return $this->sendResponse($screenshot->toArray(), "screenshot updated.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'screenshot could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function destroy(Request $request, $id) {
        try{
            $screenshot = app(Screenshots::class)->findOrFail($id);

            if (!isset($screenshot)) {
                throw new \Exception('screenshot not found', 404);
            }

            $screenshot = $screenshot->delete();
            return $this->sendResponse(['is_deleted' => true], "screenshot deleted");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'screenshot could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
}


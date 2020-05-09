<?php

namespace App\Http\Controllers\Api\Activity;

use App\Models\Auth\User\User;
use App\Models\Activity\ActivityTBAS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiHelper;

class ActivityTBASController extends Controller
{
    use ApiHelper;
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10;

    public function index(Request $request, $activity_id)
    {
        try {
            $params = $request->all();
            $activity_tba_query = null;

            if (array_key_exists('id', $params)) {
                $activity_tba_query = ActivityTBAS::where('id', $params['id']);
            }

            if (array_key_exists('tba', $params)) {
                $activity_tba_query = ActivityTBAS::where('tba', $params['tba']);
            }

            if (isset($activity_id)) {
                $activity_tba_query = ActivityTBAS::where('activity_id', $activity_id);
            }

            if (isset($activity_tba_query)) {
                $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
                $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

                $activity_tba_query->offset($offset);
                $activity_tba_query->limit($limit);

                return $this->sendResponse($activity_tba_query->get()->toArray(), "Activity fetched.");
            } else {
                throw new \Exception("No Activity tba found.", 404);
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity tba/s could not be fetched',
                ['error'=>'query filters not supported'],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request, $activity_id)
    {
        try {
            $request->validate([
                    'tba' => 'required',
                ]);

            $params = $request->all();
            $new_atba = new ActivityTBAS;
            $new_atba->activity_id = $activity_id;
            $new_atba->tba = $params['tba'];
            $new_atba->save();

            return $this->sendResponse($new_atba->toArray(), 'Activity TBA Created.');
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity TBA could not be created',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $atba_id)
    {
        try {
            $params = $request->all();

            $atba = ActivityTBAS::find($atba_id);
            $atba->update($params);
            $atba->save();

            return $this->sendResponse($atba->toArray(), "Activity tba updated");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity tba could not be updated',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function delete($atba_id)
    {
        try {
            $atba = ActivityTBAS::find($atba_id);

            if (!isset($atba)) {
                throw new \Exception('Activity tba not found');
            }

            $atba->delete();

            return $this->sendResponse(['is_deleted' => true],"Activity tba deleted");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity tba could not be deleted',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
}

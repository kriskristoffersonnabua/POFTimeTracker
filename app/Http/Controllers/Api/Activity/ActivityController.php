<?php

namespace App\Http\Controllers\Api\Activity;

use App\Models\Auth\User\User;
use App\Models\Activity\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiHelper;

class ActivityController extends Controller
{
    use ApiHelper;

    public function get(Request $request)
    {
        try {
            $params = $request->all();
            $activity_query = null;

            if (array_key_exists('id', $params)) {
                $activity_query = Activity::where('id', $params['id']);
            }

            if (array_key_exists('subproject_id', $params)) {
                $activity_query = Activity::where('subproject_id', $params['subproject_id']);
            }

            if (array_key_exists('activity_no', $params)) {
                $activity_query = Activity::where('activity_no', $params['activity_no']);
            }

            if (array_key_exists('employee_user_id', $params)) {
                $activity_query = Activity::where('employee_user_id', $params['employee_user_id']);
            }

            if (array_key_exists('activity_no', $params)) {
                $activity_query = Activity::where('activity_no', $params['activity_no']);
            }

            if (isset($activity_query)) {
                return $this->sendResponse($activity_query->get()->toArray(), "Activity fetched.");
            } else {
                throw new Exception("No Activity found.", 404);
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity could not be fetched',
                ['error'=>'query filters not supported'],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                    'subproject_id' => 'required',
                    'activity_no' => 'required',
                    'employee_user_id' => 'required',
                    'title' => 'required',
                    'description' => 'required',
                    'acceptance_criteria' => 'required',
                    'estimated_hours' => 'required'
                ]);

            $params = $request->all();
            $new_activity = new Activity;
            $new_activity->subproject_id = $params['subproject_id'];
            $new_activity->activity_no = $params['activity_no'];
            $new_activity->employee_user_id = $params['employee_user_id'];
            $new_activity->title = $params['title'];
            $new_activity->description = $params['description'];
            $new_activity->acceptance_criteria = $params['acceptance_criteria'];
            $new_activity->estimated_hours = $params['estimated_hours'];
            $new_activity->save();

            return $this->sendResponse($new_activity->toArray(), 'Activity Created.');
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity could not be created',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $activity_id)
    {
        try {
            $params = $request->all();

            $activity = Activity::find($activity_id);
            $activity->update($params);
            $activity->save();

            return $this->sendResponse($activity->toArray(), "Activity updated");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity could not be updated',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function delete($activity_id)
    {
        try {
            $activity = Activity::find($activity_id);
            $activity->delete($params);

            return $this->sendResponse($activity->toArray(), "Activity deleted");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity could not be deleted',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
}

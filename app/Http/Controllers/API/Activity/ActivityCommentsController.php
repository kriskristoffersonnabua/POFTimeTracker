<?php

namespace App\Http\Controllers\Api\Activity;

use App\Models\Auth\User\User;
use App\Models\Activity\ActivityComments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiHelper;

class ActivityCommentsController extends Controller
{
    use ApiHelper;

    public function index(Request $request, $activity_id)
    {
        try {
            $params = $request->all();
            $activity_comment_query = null;

            if (array_key_exists('id', $params)) {
                $activity_comment_query = ActivityComments::where('id', $params['id']);
            }

            if (array_key_exists('comment', $params)) {
                $activity_comment_query = ActivityComments::where('tba', $params['tba']);
            }

            if (isset($activity_id)) {
                $activity_comment_query = ActivityComments::where('activity_id', $activity_id);
            }

            if (isset($activity_comment_query)) {
                return $this->sendResponse($activity_comment_query->get()->toArray(), "Activity fetched.");
            } else {
                throw new \Exception("No Activity comment found.", 404);
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity comment/s could not be fetched',
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
                    'user_id' => 'required',
                    'comment' => 'required',
                    'date_added' => 'required',
                ]);

            $params = $request->all();
            $new_activity_comment = new ActivityComments;
            $new_activity_comment->activity_id = $activity_id;
            $new_activity_comment->user_id = $params[ 'user_id' ];
            $new_activity_comment->comment = $params[ 'comment' ];
            $new_activity_comment->date_added = $params[ 'date_added' ];
            $new_activity_comment->save();

            return $this->sendResponse($new_activity_comment->toArray(), 'Activity comment Created.');
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity comment could not be created',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $comment_id)
    {
        try {
            $params = $request->all();

            $activity_comment = ActivityComments::find($comment_id);
            $activity_comment->update($params);
            $activity_comment->save();

            return $this->sendResponse($activity_comment->toArray(), "Activity comment updated");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity comment could not be updated',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function delete($comment_id)
    {
        try {
            $activity_comment = ActivityComments::find($comment_id);

            if (!isset($activity_comment)) {
                throw new \Exception('Activity comment not found');
            }

            $activity_comment->delete();

            return $this->sendResponse(['is_deleted' => true], "Activity comment deleted");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Activity comment could not be deleted',
                ['error'=>$e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
}

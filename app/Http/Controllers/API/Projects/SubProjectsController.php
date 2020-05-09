<?php

namespace App\Http\Controllers\API\Projects;

use App\Models\Projects\SubProjects;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiHelper;

class SubProjectsController extends Controller
{
    use ApiHelper;
    const DEFAULT_OFFSET = 0;
    const DEFAULT_LIMIT = 10;

    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $subproject_query = null;

            if (array_key_exists('id', $params)) {
                $subproject_query = SubProjects::where('id', $params['id']);
            }

            if (array_key_exists('subproject_no', $params)) {
                $subproject_query = SubProjects::where('subproject_no', $params['subproject_no']);
            }

            if (array_key_exists('subproject_name', $params)) {
                $subproject_query = SubProjects::where('subproject_name', $params['subproject_name']);
            }

            if (array_key_exists('user_id', $params)) {
                $subproject_query = SubProjects::where('user_id', $params['user_id']);
            }

            if (array_key_exists('project_id', $params)) {
                $subproject_query = SubProjects::where('project_id', $params['project_id']);
            }

            if (isset($subproject_query)) {
                $offset = $request->get('offset') ?? self::DEFAULT_OFFSET;
                $limit = $request->get('limit') ?? self::DEFAULT_LIMIT;

                $subproject_query->offset($offset);
                $subproject_query->limit($limit);

                return $this->sendResponse($subproject_query->get()->toArray(), "Subproject/s fetched.");
            } else {
                throw new Exception("No Subproject found.", 404);
            }
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject/s could not be fetched',
                [ 'error' => $e->getMessage() ],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function show(Request $request, $subproject_id)
    {
        try {
            $subproject = SubProjects::find($subproject_id);

            if (!isset($subproject)) {
                throw new \Exception('Subproject not found', 404);
            }

            $this->sendResponse($subproject->toArray(), "Subproject found.") ;
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject could not be found with that id',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "project_id" => 'required',
                "subproject_no" => 'required',
                "subproject_name" => 'required',
                "user_id" => 'required',
                "description" => 'required'
            ]);
            $params = $request->all();

            $new_subproject = new SubProjects;
            $new_subproject->project_id = (int)$params['project_id'];
            $new_subproject->subproject_no = $params['subproject_no'];
            $new_subproject->subproject_name = $params['subproject_name'];
            $new_subproject->user_id = $params['user_id'];
            $new_subproject->description = $params['description'];

            $new_subproject->save();

            return $this->sendResponse($new_subproject->toArray(), "Subproject created");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject could not be created',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function update(Request $request, $subproject_id)
    {
        try {
            $params = $request->all();

            $subproject = SubProjects::find($subproject_id);

            if (!isset($subproject)) {
                throw new \Exception("Subproject not existing", 404);
            }

            $subproject->update($params);
            $subproject->save();

            return $this->sendResponse($subproject->toArray(), "Subproject updated");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject could not be updated',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }

    public function delete($subproject_id)
    {
        try {
            $subproject = SubProjects::find($subproject_id);

            if (!isset($subproject)) {
                throw new \Exception("Subproject not existing", 404);
            }
            $subproject->delete();

            return $this->sendResponse(['is_deleted' => true], "Subproject deleted");
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            return $this->sendError(
                'Subproject could not be deleted',
                ['error'=> $e->getMessage()],
                $errorCode && $errorCode <= 500 ?
                    $errorCode: 500
            );
        }
    }
}

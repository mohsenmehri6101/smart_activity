<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Activity",
    description: "Endpoints for managing activities"
)]
class ActivityController extends Controller
{
    public function __construct(public ActivityService $activityService)
    {
    }

    #[OA\Get(
        path: "/api/activities",
        summary: "Get a list of activities",
        tags: ["Activity"],
        parameters: [
            new OA\Parameter(
                name: "type",
                in: "query",
                description: "Filter by activity type",
                required: false,
                schema: new OA\Schema(type: "string", enum: ["task_created", "comment_added"])
            ),
            new OA\Parameter(
                name: "actor",
                in: "query",
                description: "Filter by actor",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "from",
                in: "query",
                description: "Start date for filtering activities",
                required: false,
                schema: new OA\Schema(type: "string", format: "date")
            ),
            new OA\Parameter(
                name: "to",
                in: "query",
                description: "End date for filtering activities",
                required: false,
                schema: new OA\Schema(type: "string", format: "date")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Activities retrieved successfully"),
            new OA\Response(response: 500, description: "Error retrieving activities")
        ]
    )]
    public function index(ActivityRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $activities = $this->activityService->get($filters,paginate: true);
        return $this->apiResponseStandard($activities, 'لیست فعالیت‌ها با موفقیت دریافت شد.');
    }

    #[OA\Get(
        path: "/api/activities/{id}",
        summary: "Get a single activity by ID",
        tags: ["Activity"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the activity",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Activity retrieved successfully"),
            new OA\Response(response: 404, description: "Activity not found"),
            new OA\Response(response: 500, description: "Error retrieving activity")
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $activity = $this->activityService->find($id);

        if (!$activity) {
            return $this->apiResponseStandard(null, 'فعالیت یافت نشد.', false, 404);
        }

        return $this->apiResponseStandard($activity, 'فعالیت با موفقیت دریافت شد.');
    }

    #[OA\Post(
        path: "/api/activities",
        summary: "Create a new activity",
        tags: ["Activity"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    properties: [
                        new OA\Property(property: "type", type: "string", description: "Activity type: task_created or comment_added"),
                        new OA\Property(property: "actor", type: "string", description: "Actor performing the activity"),
                        new OA\Property(property: "target", type: "string", description: "Target of the activity"),
                        new OA\Property(property: "timestamp", type: "string", format: "date-time", description: "Activity timestamp"),
                        new OA\Property(property: "metadata", type: "array", description: "Additional metadata", nullable: true, items: new OA\Items(type: "string"))
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Activity created successfully"),
            new OA\Response(response: 500, description: "Error creating activity")
        ]
    )]

    public function store(ActivityRequest $request): JsonResponse
    {
        $data = $request->validated();
        $activity = $this->activityService->create($data);

        return $this->apiResponseStandard($activity, 'فعالیت با موفقیت ایجاد شد.', true, 201);
    }

    #[OA\Put(
        path: "/api/activities/{id}",
        summary: "Update an existing activity",
        tags: ["Activity"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the activity",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    properties: [
                        new OA\Property(property: "type", type: "string", description: "Activity type: task_created or comment_added"),
                        new OA\Property(property: "actor", type: "string", description: "Actor performing the activity"),
                        new OA\Property(property: "target", type: "string", description: "Target of the activity"),
                        new OA\Property(property: "timestamp", type: "string", format: "date-time", description: "Activity timestamp"),
                        new OA\Property(property: "metadata", type: "array", description: "Additional metadata", nullable: true, items: new OA\Items(type: "string"))
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Activity updated successfully"),
            new OA\Response(response: 404, description: "Activity not found"),
            new OA\Response(response: 500, description: "Error updating activity")
        ]
    )]
    public function update(ActivityRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $activity = $this->activityService->update($id, $data);

        if (!$activity) {
            return $this->apiResponseStandard(null, 'فعالیت یافت نشد یا آپدیت انجام نشد.', false, 404);
        }

        return $this->apiResponseStandard($activity, 'فعالیت با موفقیت بروزرسانی شد.');
    }

    #[OA\Delete(
        path: "/api/activities/{id}",
        summary: "Delete an activity by ID",
        tags: ["Activity"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID of the activity",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Activity deleted successfully"),
            new OA\Response(response: 404, description: "Activity not found"),
            new OA\Response(response: 500, description: "Error deleting activity")
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->activityService->delete($id);

        if (!$deleted) {
            return $this->apiResponseStandard(null, 'فعالیت یافت نشد یا حذف انجام نشد.', false, 404);
        }

        return $this->apiResponseStandard(null, 'فعالیت با موفقیت حذف شد.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function __construct(public ActivityService $activityService)
    {
    }

    public function index(ActivityRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $activities = $this->activityService->get($filters,paginate: true);
        return $this->apiResponseStandard($activities, 'لیست فعالیت‌ها با موفقیت دریافت شد.');
    }

    public function show(int $id): JsonResponse
    {
        $activity = $this->activityService->find($id);

        if (!$activity) {
            return $this->apiResponseStandard(null, 'فعالیت یافت نشد.', false, 404);
        }

        return $this->apiResponseStandard($activity, 'فعالیت با موفقیت دریافت شد.');
    }

    public function store(ActivityRequest $request): JsonResponse
    {
        $data = $request->validated();
        $activity = $this->activityService->create($data);

        return $this->apiResponseStandard($activity, 'فعالیت با موفقیت ایجاد شد.', true, 201);
    }

    public function update(ActivityRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $activity = $this->activityService->update($id, $data);

        if (!$activity) {
            return $this->apiResponseStandard(null, 'فعالیت یافت نشد یا آپدیت انجام نشد.', false, 404);
        }

        return $this->apiResponseStandard($activity, 'فعالیت با موفقیت بروزرسانی شد.');
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->activityService->delete($id);

        if (!$deleted) {
            return $this->apiResponseStandard(null, 'فعالیت یافت نشد یا حذف انجام نشد.', false, 404);
        }

        return $this->apiResponseStandard(null, 'فعالیت با موفقیت حذف شد.');
    }


}

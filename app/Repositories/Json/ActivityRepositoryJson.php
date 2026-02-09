<?php

namespace App\Repositories\Json;

use App\Repositories\Contracts\ActivityRepositoryInterface;

class ActivityRepositoryJson implements ActivityRepositoryInterface
{
    protected string $file;

    public function __construct()
    {
        $this->file = storage_path('activities.json');

        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
    }

    public function all(array $filters = []): array
    {
        $activities = json_decode(file_get_contents($this->file), true);

        if ($filters) {
            $activities = array_filter($activities, function ($activity) use ($filters) {
                if (isset($filters['type']) && $activity['type'] !== $filters['type']) {
                    return false;
                }
                if (isset($filters['actor']) && stripos($activity['actor'], $filters['actor']) === false) {
                    return false;
                }
                if (isset($filters['from']) && $activity['timestamp'] < $filters['from']) {
                    return false;
                }
                if (isset($filters['to']) && $activity['timestamp'] > $filters['to']) {
                    return false;
                }
                return true;
            });
        }

        return array_values($activities);
    }

    public function find(int $id): ?array
    {
        $activities = $this->all();
        foreach ($activities as $activity) {
            if ($activity['id'] == $id) return $activity;
        }
        return null;
    }

    public function create(array $data): array
    {
        $activities = $this->all();
        $data['id'] = count($activities) ? max(array_column($activities, 'id')) + 1 : 1;
        $activities[] = $data;
        file_put_contents($this->file, json_encode($activities, JSON_PRETTY_PRINT));
        return $data;
    }

    public function update(int $id, array $data): ?array
    {
        $activities = $this->all();
        foreach ($activities as &$activity) {
            if ($activity['id'] == $id) {
                $activity = array_merge($activity, $data);
                file_put_contents($this->file, json_encode($activities, JSON_PRETTY_PRINT));
                return $activity;
            }
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $activities = $this->all();
        foreach ($activities as $key => $activity) {
            if ($activity['id'] == $id) {
                unset($activities[$key]);
                file_put_contents($this->file, json_encode(array_values($activities), JSON_PRETTY_PRINT));
                return true;
            }
        }
        return false;
    }

    public function paginate(int $page = 1, int $perPage = 15, array $filters = []): array
    {
        // TODO: Implement paginate() method.
    }
}

<?php

namespace App\Services;

use App\Repositories\Contracts\ActivityRepositoryInterface;

class ActivityService
{
    public function __construct(protected ActivityRepositoryInterface $repository)
    {
    }

    public function get(array $filters = [],bool $paginate=true): array
    {
        if($paginate){
            $page = request('page',1);
            $perPage = request('per_page',request('perPage',15));
            return $this->repository->paginate(page: $paginate, perPage: $perPage, filters: $filters);
        }
        return $this->repository->all($filters);
    }


    public function find(int $id): ?array
    {
        return $this->repository->find($id);
    }

    public function create(array $data): array
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?array
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

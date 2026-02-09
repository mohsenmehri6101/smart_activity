<?php

namespace App\Repositories\Contracts;

interface ActivityRepositoryInterface
{
    public function all(array $filters = []): array;
    public function paginate(
        int $page = 1,
        int $perPage = 15,
        array $filters = []
    ): array;
    public function find(int $id): ?array;
    public function create(array $data): array;
    public function update(int $id, array $data): ?array;
    public function delete(int $id): bool;
}

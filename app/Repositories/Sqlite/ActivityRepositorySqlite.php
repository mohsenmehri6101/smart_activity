<?php

namespace App\Repositories\Sqlite;

use App\Repositories\Contracts\ActivityRepositoryInterface;
use PDO;

class ActivityRepositorySqlite implements ActivityRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(string $databasePath = null)
    {
        $databasePath ??= database_path('database.sqlite');
        $this->pdo = new PDO('sqlite:' . $databasePath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS activities (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                type TEXT NOT NULL,
                actor TEXT NOT NULL,
                target TEXT NOT NULL,
                timestamp TEXT NOT NULL,
                metadata TEXT
            )
        ");
    }

    private function buildQuery(array $filters = []): array
    {
        $sql = "FROM activities WHERE 1=1";
        $params = [];

        if (!empty($filters['type'])) {
            $sql .= " AND type = :type";
            $params[':type'] = $filters['type'];
        }

        if (!empty($filters['actor'])) {
            $sql .= " AND actor LIKE :actor";
            $params[':actor'] = '%' . $filters['actor'] . '%';
        }

        if (!empty($filters['from'])) {
            $sql .= " AND timestamp >= :from";
            $params[':from'] = $filters['from'];
        }

        if (!empty($filters['to'])) {
            $sql .= " AND timestamp <= :to";
            $params[':to'] = $filters['to'];
        }

        return [$sql, $params];
    }

    /* ================= READ ================= */

    public function all(array $filters = []): array
    {
        [$sql, $params] = $this->buildQuery($filters);

        $stmt = $this->pdo->prepare("SELECT * {$sql} ORDER BY id DESC");
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginate(int $page = 1, int $perPage = 15, array $filters = []): array
    {
        $page = max($page, 1);
        $offset = ($page - 1) * $perPage;

        [$sql, $params] = $this->buildQuery($filters);

        // total
        $countStmt = $this->pdo->prepare("SELECT COUNT(*) {$sql}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        // data
        $stmt = $this->pdo->prepare("
            SELECT * {$sql}
            ORDER BY id DESC
            LIMIT :limit OFFSET :offset
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'meta' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => (int) ceil($total / $perPage),
            ],
        ];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM activities WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $activity = $stmt->fetch(PDO::FETCH_ASSOC);
        return $activity ?: null;
    }

    public function create(array $data): array
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO activities (type, actor, target, timestamp, metadata)
            VALUES (:type, :actor, :target, :timestamp, :metadata)
        ");
        $stmt->execute([
            ':type' => $data['type'],
            ':actor' => $data['actor'],
            ':target' => $data['target'],
            ':timestamp' => $data['timestamp'],
            ':metadata' => isset($data['metadata']) ? json_encode($data['metadata']) : null,
        ]);
        $data['id'] = (int)$this->pdo->lastInsertId();
        return $data;
    }

    public function update(int $id, array $data): ?array
    {
        $activity = $this->find($id);
        if (!$activity) return null;

        $stmt = $this->pdo->prepare("
            UPDATE activities SET type=:type, actor=:actor, target=:target, timestamp=:timestamp, metadata=:metadata
            WHERE id=:id
        ");
        $stmt->execute([
            ':type' => $data['type'] ?? $activity['type'],
            ':actor' => $data['actor'] ?? $activity['actor'],
            ':target' => $data['target'] ?? $activity['target'],
            ':timestamp' => $data['timestamp'] ?? $activity['timestamp'],
            ':metadata' => isset($data['metadata']) ? json_encode($data['metadata']) : $activity['metadata'],
            ':id' => $id,
        ]);

        return $this->find($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM activities WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

}

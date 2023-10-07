<?php

namespace base;

use database\Database;

abstract class BaseModel
{

    protected Database $db;
    protected string $table;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function insert(array $data) : null|string
    {
        return $this->db->insert($this->table, $data);
    }

    public function select(array|string $selectedFields, array $params = []): bool|array
    {
        return $this->db->select($this->table, $selectedFields, $params);
    }

    public function search(array $selectedFields, string $field, string $data): bool|array
    {
        return $this->db->search($this->table, $selectedFields, $field, $data);
    }

    public function update(string $id, array $params): bool
    {
        return $this->db->update($this->table, $id, $params);
    }

    public function delete(string $id): bool
    {
        return $this->db->delete($this->table, $id);
    }

}
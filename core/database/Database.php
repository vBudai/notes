<?php

namespace database;

use database\DbConnect;

class Database
{

    private DbConnect $db;


    public function __construct()
    {
        $this->db = new DbConnect();
    }


    public function insert(string $table, array $data) : null|string
    {
        if($table == "" || empty($data))
            return null;

        $i = 0;
        $coll = '';
        $mask = '';
        foreach ($data as $key => $value) {
             if ($i === 0) {
                 $coll = $coll . "$key";
                 $mask = $mask . "'" . "$value" . "'";
             } else {
                 $coll = $coll . ", $key";
                 $mask = $mask . ", '" . "$value" . "'";
             }
             $i++;
        }

        $sql = "INSERT INTO $table ($coll) VALUES ($mask)";

        $query = $this->db->getConn()->prepare($sql);

        if($query->execute())
            return $this->db->getConn()->lastInsertId();
        else
            return null;
    }

    public function select(string $table, array|string $selectedFields, array $params): null|array
    {
        if($table == "")
            return null;

        $sql = "";
        if(is_string($selectedFields))
            $sql = "SELECT $selectedFields FROM $table";
        else
            $sql = "SELECT " . implode(', ', $selectedFields) . " FROM $table";

        if(!empty($params)){
            $i = 0;
            foreach ($params as $key => $value){
                if(!is_numeric($value))
                    $value = "'" . $value . "'";
                if($i === 0)
                    $sql = $sql . " WHERE $key = $value";
                else
                    $sql = $sql . " AND $key = $value";

                $i++;
            }
        }

        $query = $this->db->getConn()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function update(string $table, string $id, array $params): bool
    {
        $i = 0;
        $str = '';
        foreach ($params as $key => $value){
            if($i === 0)
                $str = $str . $key . " = '" . $value . "'";
            else
                $str = $str .", " . $key . " = '" . $value . "'";
            $i++;
        }

        $sql = "UPDATE $table SET $str WHERE id=$id";
        $query = $this->db->getConn()->prepare($sql);

        return $query->execute();
    }

    public function delete(string $table, string $id) : bool
    {
        $sql = "DELETE FROM $table WHERE id=$id";
        $query = $this->db->getConn()->prepare($sql);
        return $query->execute();
    }

    /*public function search(string $table, array $selectedFields, string $field, string $data): bool|array
    {
        if($table == "")
            return false;

        $sql = "";
        if(empty($selectedFields))
            $sql = "SELECT * FROM $table WHERE $field LIKE '%$data%'";
        else
            $sql = "SELECT " . implode(', ', $selectedFields) . " FROM $table WHERE $field LIKE '%$data%'";

        $query = $this->db->getConn()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }*/

}
<?php
namespace App\Model;
/**
 * Class MainModel
 * Creates Queries for CRUD
 */
abstract class MainModel
{
    /**
     * Database
     */
    protected $database = null;
    /**
     * Database Table
     */
    protected $table = null;
    /*
     * Variable to stock user POST values
     */
    protected $user = [];
    /**
     * Model constructor
     * Receives the Database Object & creates the Table Name
     */
    public function __construct(PDOModel $database)
    {
        $this->database = $database;
        $model          = explode('\\', get_class($this));
        $this->table    = ucfirst(str_replace('Model', '', array_pop($model)));
    }
    /**
     * Lists all Data from the id or another key
     */
    public function listData(string $value = null, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
            return $this->database->getAllData($query, [$value]);
        }
        $query = 'SELECT * FROM ' . $this->table;
        return $this->database->getAllData($query);
    }
    /**
     * Creates a new Data entry
     */
    public function createData(array $data)
    {
        $keys   = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $query  = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';
        $this->database->setData($query);
    }
    /**
     * Reads Data from its id or another key
     */
    public function readData(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        }
        return $this->database->getData($query, [$value]);
    }
    /**
     * Updates Data from its id or another key
     */
    public function updateData(string $value, array $data, string $key = null)
    {
        $set = null;
        foreach ($data as $dataKey => $dataValue) {
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }
        $set = substr_replace($set, '', -2);
        if (isset($key)) {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ?';
        }
        $this->database->setData($query, [$value]);
    }
    /**
     * Deletes Data from its id or another key
     */
    public function deleteData(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }
        $this->database->setData($query, [$value]);
    }
}
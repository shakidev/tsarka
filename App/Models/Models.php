<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 4:58 PM
 */

namespace App\Models;


use App\Database\Database;

class Models extends Database
{

    protected $connection;

    protected $table;

    protected $query = [];

    protected $operators = ["like",'not like','=','!='];

    protected $joins = [];
    protected $groupBy = [];
    protected $column = '*';
    protected $sets = [];

    //Closure вариант не реализован
    public function where($column, $operator = "=", $value = null, $boolean = 'and')
    {
        if(!in_array($operator,$this->operators)){
            $value = $operator;
            $operator = "=";
        }
        if(empty($this->query)){
            $boolean = "";
        }
        $this->query[] = (object)[
            "column" => $column,
            "value" => $value,
            "operator" => $operator,
            "boolean" => $boolean
            ];
        return $this;
    }

    //Closure вариант не реализован
    public function orWhere($column, $operator = "=", $value = null)
    {
        return $this->where($column, $operator, $value, 'or');
    }

    public function find($value = null)
    {
        return $this->where("id", "=", $value);
    }

    public function leftJoin($table, $foreign,$references){
        $this->joins[] = "LEFT JOIN {$table} ON {$table}.{$foreign} = {$this->table}.{$references}";
        $this->column .= " ,{$this->table}.id as {$this->table}ID";
        return $this;
    }

    public function groupBy($column,$sort){
        $this->groupBy[] = " GROUP BY {$column} {$sort}";
        return $this;
    }

    public function getQuery($type = "select",$columns = '*',$limit = null){
        switch ($type){
            case "select":
                $query = "SELECT {$this->column} FROM {$this->table}";
                break;
            case "update":
                $query = "UPDATE {$this->table} SET";
                break;
            case "destroy":
                $query = "DELETE FROM {$this->table}";
                break;
             default:
                $query = "SELECT {$this->column} FROM {$this->table}";
                break;
        }
        $values = [];
        if($this->joins){
            $query .= " ".implode(" ",$this->joins);
        }
        if($this->sets){
            $values = $this->sets['value'];
            $query .= " ".implode(",",$this->sets['query']);
        }
        if($this->query){
            $pre = [];
            foreach ($this->query as $q){
                $pre[] = "{$q->boolean} {$q->column} {$q->operator} ?";
                $values[] = $q->value;
            }
            $query .= " WHERE ".implode(" ",$pre);
        }
        if($this->groupBy){
            $query .= " ".implode(" ",$this->groupBy);
        }
        $query .= (isset($limit) ? " LIMIT {$limit}" : '');
        return ['query' => $query, 'values' => $values];
    }



    public function get()
    {
        return $this->query($this->getQuery()['query'],$this->getQuery()['values']);
    }

    public function first()
    {
        return $this->query($this->getQuery()['query'],$this->getQuery()['values'],false);
    }

    public function create(array $data){
        $columns = [];
        $values = [];
        $preparedColumns = [];
        $execute = [];
        foreach ($data as $column => $value){
            $columns[] = $column;
            $values[] = $value;
            $preparedColumns[] = ":".$column;
            $execute = array_merge($execute,[$column => $value]);
        }
        $statement = $this->connection->prepare("INSERT INTO {$this->table} (".append($columns).")
    VALUES (".append($preparedColumns).")");
        $statement->execute($execute);
        return $this->connection->lastInsertId();
    }


    public function delete(){
        return $this->execute($this->getQuery("destroy")['query'],$this->getQuery("destroy")['values']);
    }

    public function update(array $data){
        foreach ($data as $key => $value){
            $this->sets["query"][] = "{$key}=?";
            $this->sets["value"][] = $value;
        }
        return $this->execute($this->getQuery("update")['query'],$this->getQuery("update")['values'],false);
    }


    public function table($table){
        $this->table = $table;
        return $this;
    }
}
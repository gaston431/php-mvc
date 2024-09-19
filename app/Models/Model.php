<?php

namespace App\Models;

use mysqli;
use PDO;
use PDOException;

class Model{
    protected $db_host = DB_HOST;
    //protected $db_port = DB_PORT;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;

    protected $query;

    protected $select = '*';
    protected $where, $values = [];
    protected $orderBy;

    protected $table;

    public function __construct()
    {
        $this->connection();
    }

    public function connection()
    {
        //mysql:host=hostname;dbname=ssldb  new PDO("mysql:host=$cfg[mysqlHost];dbname=$cfg[mysqlDatabase];charset=utf8mb4
        //$dsn = 'mysql:' . http_build_query($config, '', ';');

        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";
                
        try {
            $this->connection = new PDO($dsn, $this->db_user, $this->db_pass, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            print "    <p class=\"aviso\">Error: No puede conectarse con la base de datos. {$e->getMessage()}</p>\n";
            exit;
        }

        //$this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        
        /* if ($this->connection->connect_errno) {
            die('Error de conexión: ' . $this->connection->connect_error);
        } */

    }

    public function query($sql, $params = []){
        $this->query = $this->connection->prepare($sql);

        $this->query->execute($params);

        return $this;
    }

    public function get(){
        if (empty($this->query)) {

            $sql = "SELECT {$this->select} FROM {$this->table}";
            
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $this->query($sql, $this->values);
        }

        return $this->query->fetchAll();
    }    

    /* public function query($sql, $data = [], $params = null){

        if ($data) {

            if ($params == null) {
                $params = str_repeat('s', count($data));
            }

            $smtp = $this->connection->prepare($sql);
            $smtp->bind_param($params, ...$data);
            $smtp->execute();

            $this->query = $smtp->get_result();

        }else{

            $this->query = $this->connection->query($sql);

        }

        return $this;
    } */

    public function select(...$columns){
        $this->select = implode(', ', $columns);
        return $this;
    }

    public function where($column, $operator, $value = null){

        if ($value == null) {
            $value = $operator;
            $operator = '=';
        }

        if ($this->where) {
            $this->where .= " AND {$column} {$operator} ?";
        } else {
            $this->where = "{$column} {$operator} ?";
        }

        $this->values[] = $value;

        return $this;

    }

    public function orderBy($column, $order = 'ASC'){
        
        if ($this->orderBy) {
            $this->orderBy .= ", {$column} {$order}";
        } else {
            $this->orderBy = "{$column} {$order}";
        }

        return $this;
    }

    public function first(){

        if (empty($this->query)) {

            $sql = "SELECT {$this->select} FROM {$this->table}";
            
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $this->query($sql, $this->values);
        }

        return $this->query->fetch();
    }

    /* public function get(){
        if (empty($this->query)) {

            $sql = "SELECT {$this->select} FROM {$this->table}";
            
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $this->query($sql, $this->values);
        }

        return $this->query->fetch_all(MYSQLI_ASSOC);
    } */

    public function paginate($cant = 15)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if (empty($this->query)) {

            $sql = "SELECT {$this->select} FROM {$this->table}";
            
            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $sql .= " LIMIT " . ($page - 1) * $cant . ", $cant";

            $data = $this->query($sql, $this->values)
                        ->get();
        }

        $total = $this->query("SELECT FOUND_ROWS() as total")->first()['total'];

        //Recuperar uri
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');

        //Eliminar el parámetro page
        if (strpos($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        $last_page = ceil($total / $cant);

        return [
            'total' => $total,
            'from' => ($page - 1) * $cant + 1,
            'to' => ($page - 1) * $cant + count($data),
            'current_page' => $page,
            'last_page' => $last_page,
            'next_page' => $page < $last_page ? '?page=' . ($page + 1) : null,
            'prev_page' => $page > 1 ? '?page=' . ($page - 1) : null,
            'data' => $data,
        ];

    }

    //Consultas
    public function all(){
        $sql = "SELECT * FROM {$this->table}";

        return $this->query($sql)->get();
    }

    public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";

        return $this->query($sql, [$id])->first();
    }

    public function create($data){
        //INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)

        $columns = implode(', ', array_keys($data));
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (" . str_repeat('?,', count($values) - 1) . "?)";

        $this->query($sql, $values);

        //$insert_id = $this->connection->insert_id;
        $insert_id = $this->connection->lastInsertId();

        return $this->find($insert_id);
    }

    public function update($id, $data){

        //UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = 1

        $fields = [];

        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
        }

        $fields = implode(', ', $fields);

        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";

        $values = array_values($data);
        $values[] = $id;

        $this->query($sql, array_values($values));

        return $this->find($id);
    }

    public function delete($id){
        //DELETE FROM contacts WHERE id = 1

        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->query($sql, [$id]);

        return true;
    }
}
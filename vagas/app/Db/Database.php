<?php

namespace App\Db;


use PDO;
use PDOException;
class Database {

    const HOST ='localhost';
    const NAME ='wdev_vagas';
    const USER='root';
    const PASS='';

    private $table;
    private $connection;

        //Define a tabela e instancia a conexão
        public function __construct($table = null){
            $this->table = $table;
            $this->setConnection();
        }

        //Método responsável por criar uma conexão com o banco de dados
        private function setConnection(){
            try{
                $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                die('ERROR: '.$e->getMessage());
            }
        }

        //Método responsável por executar queries dentro do banco de dados
        public function execute($query, $params = []){
            try{
                $statement = $this->connection->prepare($query);
                $statement->execute($params);
                return $statement;
           }catch(PDOException $e){
               die('ERROR: '.$e->getMessage());
           }
       }

         //Método responsável por inserir dados no banco
         public function insert($values){

            //Dados da query
            $fields = array_keys($values);
            $binds = array_pad([], count($fields), '?');

            //Query
            $query = 'INSERT INTO '.$this->table.' ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';

            //Executa o insert
            $this->execute($query, array_values($values));

            //Retorna o ID inserido
            return $this->connection->lastInsertId();
        }

        //Método responsável por executar uma consulta no banco
        public function select($where = null, $order = null, $limit = null, $fields = '*'){

            //Dados da query
            $where = strlen($where) ? 'WHERE '.$where: '';
            $order = strlen($order) ? 'ORDER BY '.$order: '';
            $limit = strlen($limit) ? 'LIMIT '.$limit: '';

            //Monta a query
            $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

            //Executa a query
            return $this->execute($query);
        }

        //Método responsável por executar atualizações no banco de dados
        public function update($where, $values){

            //Dados da query
            $fields = array_keys($values);
            
            //Monta a query
            $query = 'UPDATE '.$this->table.' SET '.implode('=?,', $fields).'=? WHERE '.$where;

            //Executar a query
            $this->execute($query, array_values($values));

            //Retorna sucesso
            return true;
        }


        //Método responsável por excluir dados do banco
        public function delete($where){

            //Monta a query
            $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
            
            //Executa a query
            $this->execute($query);

            //Retorna sucesso
            return true;
        }
    }
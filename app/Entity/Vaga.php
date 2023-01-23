<?php

namespace App\Entity;

use App\Db\Database;

class Vaga{
    /**
     * identificador único da vaga
     * @var integer
     */
    public $id;

    /**
     * Titulo da vaga
     * @var string
     */
    public $titulo;

    /**
     * descrição da vaga
     * @var string
     */
    public $descricao;

    /**
     * define se a vaga esta ativa
     * @var string(s/n)
     */
    public $ativo;


    /**
     * data de publicação da vaga
     * @var string
     */
    public $data;


    public function cadastrar(){
        //definir a data
        $this->data = date('Y-m-d H:i:s');

        //inserir a vaga no banco
        $obDatabase = new Database('vagas');
        echo "<pre>";print_r($obDatabase); echo "</pre>";exit;



        //atribuir o id da vaga na istancia

        //retornar sucesso

    }
}
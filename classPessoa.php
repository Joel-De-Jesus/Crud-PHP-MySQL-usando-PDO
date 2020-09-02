<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classPessoa
 *
 * @author Joel Mandrasse
 */
class classPessoa {
    
    private $pdo;

    public function __construct($dbname, $host, $user, $password) {
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$password);
        } catch (PDOException $erroConn) 
        {
            echo "Erro de conexão com o banco de dados: ".$erroConn->getMessage();
        }
        catch (Exception $erro)
        {
            echo "Erro generico: ".$erro->getMessage();
        }  
    }
    
    //BUSCAR DADOS E MOSTRAR NA TABELA
    public function select()
    {
        $dados = array();
        $cmd = $this->pdo->prepare("SELECT * FROM meusdados ORDER BY nome");
        $cmd->execute();
        
        $dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    }
    
    //Funcao Cadastrar
    public function insert($nome, $telefone, $email)
    {
        //Antes de cadastrar verifica se já existe o email no bd
        $cmd = $this->pdo->prepare("SELECT id from meusdados WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        
        if($cmd->rowCount()>0)//Email já existe
        {
            return false;
        }
        else 
            {
                $cmd = $this->pdo->prepare("INSERT INTO meusdados (nome, telefone, email)"
                        . "VALUES (:n, :t, :e)");
                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":t", $telefone);
                $cmd->bindValue(":e", $email);
                $cmd->execute();
                return true;
            }
    }
    
    public function delete($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM meusdados WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
    
    //Buscar dados pessoa
    public function buscarDados($id)
    {
        $dados = array();
        $cmd = $this->pdo->prepare("SELECT * FROM meusdados WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        return $dados;
    }
    
    //Actualizar dados
    public function update($nome, $telefone, $email, $id)
    {
        $cmd = $this->pdo->prepare("UPDATE meusdados SET nome=:n, "
                . "telefone=:t, email=:e WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        return true;
    }
    
}

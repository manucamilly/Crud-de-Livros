<?php
include_once('conexao/conexao.php');

$db = new Database();

class Crud{
    private $conn;
    private $table_name = "livros";

    public function __construct($db){
        $this->conn = $db;
    }

    //função para (C)riar meu registros
    public function create($postValues){
        $autor = $postValues['autor'];
        $isbn = $postValues['isbn'];
        $ano_publicacao = $postValues['ano_publicacao'];
        $genero = $postValues['genero'];
        $editora = $postValues['editora'];
        $quantidade_disponivel = $postValues['quantidade_disponivel'];
        $resenha = $postValues['resenha'];

        $query = "INSERT INTO ". $this->table_name . " (autor, isbn, ano_publicacao, genero, editora, quantidade_disponivel, resenha) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$autor);
        $stmt->bindParam(2,$isbn);
        $stmt->bindParam(3,$ano_publicacao);
        $stmt->bindParam(4,$genero);
        $stmt->bindParam(5,$editora);
        $stmt->bindParam(6,$quantidade_disponivel);
        $stmt->bindParam(7,$resenha);


        $rows = $this->read();
        if($stmt->execute()){
            print "<script>alert('Cadastro Ok!')</script>";
            print "<script> location.href='?action=read'; </script>";
            return true;
        }else{
            return false;
        }
    }

    //Função para ler os registros
    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //Função atualizar registros
    public function update($postValues){
        $id = $postValues['id'];
        $autor = $postValues['autor'];
        $isbn = $postValues['isbn'];
        $ano_publicacao = $postValues['ano_publicacao'];
        $genero = $postValues['genero'];
        $editora = $postValues['editora'];
        $quantidade_disponivel = $postValues['quantidade_disponivel'];
        $resenha = $postValues['resenha'];



        if(empty($id) || empty($autor) || empty($isbn) || empty($ano_publicacao) || empty($genero) || empty($editora) || empty($quantidade_disponivel) || empty($resenha)){
            return false;
        }

        $query = "UPDATE ". $this->table_name . " SET modelo = ?, autor = ?, isbn = ?, ano_publicacao = ?, genero = ?, editora = ?, quantidade_disponivel = ?, resenha = ?  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$autor);
        $stmt->bindParam(2,$isbn);
        $stmt->bindParam(3,$ano_publicacao);
        $stmt->bindParam(4,$genero);
        $stmt->bindParam(5,$editora);
        $stmt->bindParam(6,$quantidade_disponivel);
        $stmt->bindParam(7,$resenha);
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }

    }    
        //Função para pegar os registros do banco e inserir no formulário
        public function readOne($id){
            $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //função para apagar os registros
    public function delete($id){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

}

?>
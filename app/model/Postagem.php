<?php

class Postagem {

    public static function selecionaTodos(){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM postagem ORDER BY id DESC";
        $sql = $conn->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Postagem')) {
            $resultado[] = $row;
        }

        if (!$resultado){
            throw new Exception("Não foi encontrado nenhum registro no banco.");
        }

        return $resultado;
    }

    public static function selecionaPorId($idPost){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM postagem WHERE id = :id";
        $sql = $conn->prepare($sql);
        $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Postagem');

        if (!$resultado){
            throw new Exception("Não foi encontrado nenhum registro no banco.");
        } else  {
            $resultado->comentarios = Comentario::selectComent($resultado->id);
        }

        return $resultado;
    }

    public static function insert($dadosPost){
        if (empty($dadosPost['titulo']) OR empty($dadosPost['conteudo'])) {
            throw new Exception("Preencha todos os campos!");
            return false;
        }

        $conn = Connection::getConn();
        $sql = "INSERT INTO postagem (titulo, conteudo) VALUES (:titulo, :conteudo)";
        $sql = $conn->prepare($sql);
        $sql->bindValue(':titulo', $dadosPost['titulo']);
        $sql->bindValue(':conteudo', $dadosPost['conteudo']);
        $res = $sql->execute();

        if ($res == 0) {
            throw new Exception("Falha ao inserir postagem!");
            return false;
        }

        return true;
    }

    public static function update($paramsId){
        if (empty($paramsId['titulo']) OR empty($paramsId['conteudo'])) {
            throw new Exception("Preencha todos os campos!");
            return false;
        }

        $conn = Connection::getConn();
        $sql = "UPDATE postagem SET titulo = :titulo, conteudo = :conteudo WHERE id = :id";
        $sql = $conn->prepare($sql);
        $sql->bindValue(':titulo', $paramsId['titulo']);
        $sql->bindValue(':conteudo', $paramsId['conteudo']);
        $sql->bindValue(':id', $paramsId['id']);
        $res = $sql->execute();

        if ($res == 0) {
            throw new Exception("Falha ao alterar postagem!");
            return false;
        }

        return true;
    }

    public static function delete($id) {

        $conn = Connection::getConn();
        $sql = "DELETE FROM postagem WHERE id = :id";
        $sql = $conn->prepare($sql);
        $sql->bindValue(':id', $id);
        $res = $sql->execute();

        if ($res == 0) {
            throw new Exception("Falha ao deletar postagem!");
            return false;
        }

        return true;
    }

    
}
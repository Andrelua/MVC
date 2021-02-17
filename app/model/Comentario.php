<?php

class Comentario {

    public static function selectComent($idPost){
        $conn = Connection::getConn();

        $sql = "SELECT * FROM comentarios WHERE id_postagem = :id";
        $sql = $conn->prepare($sql);
        $sql->bindValue(':id', $idPost, PDO::PARAM_INT);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Comentario')) {
            $resultado[] = $row;
        }

        /*if (!$resultado){
            throw new Exception("Não foi encontrado nenhum registro no banco.");
        }*/

        return $resultado;
    }

    public static function insertComent($paramsId) {
        if (empty($paramsId['nome']) OR empty($paramsId['mensagem'])) {
            throw new Exception("Preencha todos os campos!");
            return false;
        }

        $conn = Connection::getConn();
        $sql = "INSERT INTO comentarios (nome, mensagem, id_postagem) VALUES (:nome, :mensagem, :id)";
        $sql = $conn->prepare($sql);
        $sql->bindValue(':nome', $paramsId['nome']);
        $sql->bindValue(':mensagem', $paramsId['mensagem']);
        $sql->bindValue(':id', $paramsId['id']);
        $res = $sql->execute();

        if ($res == 0) {
            throw new Exception("Falha ao inserir comentário!");
            return false;
        }

        return true;
    }
}
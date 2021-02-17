<?php

class PostController {

    public function index($params){
        
        try {
            $postagens = Postagem::selecionaPorId($params);
            
            $loader = new \Twig\Loader\FilesystemLoader('/opt/lampp/htdocs/MVC/app/view');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('single.html');
            
            $parametros = array();
            $parametros['id'] = $postagens->id;
            $parametros['titulo'] = $postagens->titulo;
            $parametros['conteudo'] = $postagens->conteudo;
            $parametros['comentarios'] = $postagens->comentarios;


            $conteudo = $template->render($parametros);
            echo $conteudo;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addComent(){
        try {
            Comentario::insertComent($_POST);
            echo '<script>location.href="http://localhost/MVC/index.php?pagina=post&id='.$_POST['id'].'";</script>';
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'");</script>';
            echo '<script>location.href="http://localhost/MVC/index.php?pagina=post&id='.$_POST['id'].'";</script>';
        }
        
    }
}
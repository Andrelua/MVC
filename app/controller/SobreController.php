<?php

class SobreController {

    public function index(){

        $loader = new \Twig\Loader\FilesystemLoader('/opt/lampp/htdocs/MVC/app/view');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('sobre.html');
        
        $parametros = array();
        
        $conteudo = $template->render($parametros);
        echo $conteudo;
    }
}
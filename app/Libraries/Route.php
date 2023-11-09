<?php 
    // TODO: Criar uma classe que realize o tratamento das rotas e das URL's.
    class Route
    {
        private $controller = "Pages";
        private $method = "index";
        private $parameters = [];

        public function __construct()
        {
            $url = $this->url() ? $this->url() : [];
            var_dump($url);
            
            // * Verificando se o controlador existe.
            if(file_exists('../app/controllers'.ucwords($url[0]) . '.php')):
                $this->controller = ucwords($url[0]);
                unset($url[0]);
            endif;

            var_dump($this->controller);
            
            
            require_once '../app/Controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;
            
            // * Verificando se o método existe
            if(isset($url[1])):
                if(method_exists($this->controller, $url[1]))
                {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            endif;

            var_dump($this->method);
            
            // * Verificando Paramêtros
            $this->parameters = $url ? array_values($url) : [];
            print_r($this->parameters);
            echo "<br>";
            echo "<br>";

            call_user_func_array([$this->controller, $this->method], $this->parameters);
            

        }

        // * Método para tratar e manipular URL
        private function url()
        {
            // ? Filtrando a url contra SQL_INJECTION
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            if(isset($url)):
                $url = trim(rtrim($url, '/'));
                $url = explode('/', $url);
                return $url;
            endif;
            
        }
    }
?>



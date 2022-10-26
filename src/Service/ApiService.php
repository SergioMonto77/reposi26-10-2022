<?php

    //vamos a crear los servicios para poder traer los datos de las peliculas

    namespace App\Service;

    //aunque aquí no debo poner el autoload (al ser una clase), lo voy a poner para poder hacer ejemplos
    //require __DIR__."/../../vendor/autoload.php"; //debo salir dos directorios para poder entrar en la carpeta vendor y llamar al autoload

    use App\Modelos; //si quiero crear un objeto de la clase pelicula debo hacer uso de su namespace 

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../../'); //salgo de service, salgo de modelos e indico donde está mi .env
    //siempre que utilice una librería de vendor (no de src) tengo que indicar al principio '\'
    $dotenv->load();
    //podría poner use \Dotenv\Dotenv; y luego a la hora de usarlo poner = Dotenv::createImmutable...

    // define("URL", "https://api.themoviedb.org/3/movie/popular?api_key=88ff4bcf214ae53f278f59cea3c4f1d0&page=1");
    // //mediante define he creado la constante 'URL' y le doy el valor de mi api de movies que he creado

    // define("IMG", "https://image.tmdb.org/t/p/w500"); //esta ruta está en la docu de la api y es la que me da acceso a las imagenes
    define ("URL", $_ENV['URL_BASE'].$_ENV['API_KEY']);
    define ("IMG", $_ENV['URL_IMG']);

    class ApiService{
        
        public function getPeliculas():array{ //esta función me devolverá un array con las peliculas
            $peliculas=[];
            $datos= file_get_contents(URL);
            $datosJson=json_decode($datos); //json_decode convierte un archivo en un json para poder verlo

            // echo "<pre>";
            // var_dump($datosJson); //esta clase tiene 4 atributos (page, results, total_pages y total_results)
            // echo "</pre>";

            $datosPelis=$datosJson->results;
            // echo "<pre>";
            // var_dump($datosPelis); //esto es un array de 20 objetos tipo stdClass (objetos genéricos de la clase php)
            // echo "</pre>";

            //datosPelis es un array de 20 objetos, así que vamos a recorrerlo
            foreach ($datosPelis as $objetoPelicula){//no me interesan las claves ya que son numéricas y no me aportan nada
                $peliculas[]= (new Modelos\Pelicula)->setTitulo($objetoPelicula->title)
                ->setResumen($objetoPelicula->overview)
                ->setCaratula(IMG.$objetoPelicula->backdrop_path) //ahora ya lo que me devuelve puedo cargarlo (es una img de internet)
                ->setFechaEstreno($objetoPelicula->release_date)
                ->setPoster(IMG.$objetoPelicula->poster_path);
            }
            // echo "<pre>";
            // var_dump($peliculas); 
            // echo "</pre>";

            return $peliculas;

        }

    }

    //fuera de la clase me creo un objeto de esta para probarlo (esto no se haría así)
    //(new ApiService)->getPeliculas(); //al ser constructor vacío no tengo que poner ApiService()
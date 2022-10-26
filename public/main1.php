<?php

    require __DIR__."/../vendor/autoload.php";

    use App\Service;

    $peliculas= (new Service\ApiService)->getPeliculas();

    // echo "<pre>";
    // var_dump($peliculas);
    // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>main</title>
</head>

<body style="background-color:dimgrey">
    <div class="container mt-4">

            <div id="peli" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                        $cont=1;
                        foreach ($peliculas as $peli){
                            echo ($cont==1) ? "<div class='carousel-item active'>" : "<div class='carousel-item'>"; //active indica el que me va a mostrar (siempre debe ser active el primero)
                            echo <<<TXT
                            <div class="card" style="ºwidth:36rem">
                            <img src="{$peli->getCaratula()}" class="card-img-top" alt="Poster peli">
                            <div class="card-body">
                                <h5 class="card-title">{$peli->getTitulo()}</h5>
                                <p class="card-text">{$peli->getResumen()}</p>
                                <p class="card-text">Fecha estreno: {$peli->getFechaEstreno()}</p>
                            </div>
                            </div>
                            TXT; //cojo las 'card' de bootstrap
                            echo "</div>";
                            $cont++;
                        }   
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#peli" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#peli" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

    </div>
</body>

</html>
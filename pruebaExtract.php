<?php

$miArray = [
    "codigo" => 200,
    "nombre" => "pepe",
    "saldo" => 432
];

extract($miArray);
echo $codigo;
echo $nombre;
echo $saldo;

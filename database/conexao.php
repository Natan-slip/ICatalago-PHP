<?php

const HOST = "localhost";
const USER = "root";
const PASSWORD = "Nnkm@2420";
const DATABASE = "icatalogo";

$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ($conexao == false) {
    die(mysqli_connect_error());
}

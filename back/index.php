<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "livros" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}

function listarLivros($con){
    header("Content-Type: application/json; charset=uft-8");
    $stmt = $con->query("SELECT * FROM livros");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function filtrarAutor($con){
    header("Content-Type: application/json; charset=uft-8");
    $nome = $_GET["nome"] ?? "";
    $stmt = $con->prepare("SELECT * FROM livros WHERE autorLivro = ?");
    $stmt->execute([$nome]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function adicionarLivros($con){
    $autorLivro = $_POST["autorLivro"] ?? "";
    $descricaoLivro = $_POST["descricaoLivro"] ?? "";
    $anoPublicacao = $_POST["anoPublicacao"] ?? "";

    try {
        $stmt = $con->prepare("INSERT INTO livros (autorLivro, descricaoLivro, anoPublicacao) VALUES (?,?,?)");
        $stmt -> execute([$autorLivro, $descricaoLivro, $anoPublicacao]);
        header("Location: ../front/index.html");
    }catch(PDOExeption $e){
        header("Location: ../front/erro.html");
    }
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    adicionarLivros($con);
}elseif ($rota === "listar/livros"){
    listarLivros($con);
}elseif ($rota === "filtrar/autor"){
    filtrarAutor($con);
}else {
    teste();
}
?>
<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "livros" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}

function listarLivros($con){
    header("Content-Type: application/json; charset=uft-8");
    $stmt = $con->query("SELECT * FROM livros");
    echo json_encode($stmt->fetchALL(PDO::FETCH_ASSOC));
}

function adicionarLivros($con){
    $autorLivro = $_POST["autoLivro"] ?? "";
    $descricaoLivro = $_POST["descricaoLivro"] ?? "";

    try {
        $html = $con->prepare("INSERT INTO livros (autorLivro, descricaoLivro)VALUES (?,?)");
        $html ->execute([$autorLivro, $descricaoLivro]);
        header("Location: ../front/index.html");
    }catch(PDOExeption $e){
        header("Location: ../front/erro.html");
    }
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    adicionarLivros($con);
}elseif ($rota === "livros"){
    listarLivros($con);
}else {
    teste();
}



?>
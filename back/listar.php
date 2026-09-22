<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <link rel="stylesheet" href="../front/style.css">
</head>
<body>
       
<?php
    $json=file_get_contents("http://localhost/biblioteca/back/index.php?rota=listar/livros");
    $data = json_decode($json);
   
    if (count($data)) {
       
       echo "<table>";
       echo "<tr>";
       foreach (get_object_vars($data[0]) as $coluna => $valor) {
          echo "<th>$coluna</th>";
       }
       echo "</tr>";
       foreach ($data as $idx => $livro){
           echo "<tr>";
           foreach (get_object_vars($livro) as $valor) {
                echo "<td>$valor</td>";
           }  
           echo "</tr>";    
     }
     echo "</table>";
    }
?>
</body>
</html>
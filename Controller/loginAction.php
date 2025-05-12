
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title></title>
</head>

<body>


<div class="w3-padding w3-content w3-text-grey w3-third w3-display-middle">
    <?php

session_start();


    $email = $_POST['txtEmail'];
    $senha = $_POST['txtSenha'];
    require_once('conexaoBD.php'); 


    $sql = "SELECT * FROM pessoa WHERE email = '" . $email . "';";
   // $sql2 = "SELECT nome FROM pessoa WHERE email = '" . $email . "';";


    $resultado = $conexao->query($sql);
   
    $linha = mysqli_fetch_array($resultado);


    if ($linha != null) {
        if ($linha['senha'] == $senha) {
             $nome = $linha['nome']; 

                //     echo '<a href="principal.php">
                  //      <h1 class="w3-button w3-teal">' . $nome . ', Seja Bem-Vinda! </h1>
                  //    </a>';

    echo "<script>alert('$nome, Seja Bem-Vindo(a)!'); window.location.href='../View/index.php';</script>";

                      
                       $_SESSION['logado'] = $email;
        } else {
          
                        echo "<script>alert('Login inválido!'); window.location.href='../View/pagina_login.php';</script>";
                 
                   
        }
    } else {
        echo "<script>alert('Login inválido!'); window.location.href='../View/pagina_login.php';</script>";
    }

    $conexao->close();
    ?>
</div>

</body>
</html>
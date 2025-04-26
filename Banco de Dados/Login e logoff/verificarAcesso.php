<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!isset($_SESSION['logado']) == true)) {
    header('location:acessoNegado.php');
    die();
}

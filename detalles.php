<?php
require_once 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

if (isset($_POST['cuenta'])) {
   
        function infoCuenta() {
            $cuenta = $_POST['cuenta'];
            $consulta=DB::run( "SELECT CANTIDAD, CONCEPTO, FECHA FROM Movimientos WHERE CUENTA LIKE :cuenta ", 
                [':cuenta'=>"$cuenta"]);
                return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
            $resultado = infoCuenta();
            echo json_encode($resultado);
       
}


?>
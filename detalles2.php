<?php
require_once 'conexion.php';
header('Content-Type: application/json; charset=utf-8');


if (isset($_POST['cuenta'])) {
   
        function infoMovimiento () {
            $numero_cuenta = $_POST['cuenta'];
            $consulta=DB::run( "SELECT SALDO FROM Cuentas WHERE NUMERO_CUENTA LIKE :cuenta ", 
                [':cuenta'=>"$numero_cuenta"]);
                return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
            $resultado2 = infoMovimiento();
            echo json_encode($resultado2);    
}


?>
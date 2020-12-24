<?php
header('Content-Type: application/json; charset=utf-8');

if (isset($_POST['datos'])) {
    
    /*
            //Decodifica la URL en una matriz asociativa de parametros
        function decodifacarURL( $cadena_datos) {
            $datos = array();
            foreach (explode('&', $cadena_datos) as $dato) {
                $param = explode("=", $dato);
                if ($param) {
                        $clave = urldecode($param[0]);
                        $valor = urldecode($param[1]);
                        $datos[$clave] = $valor;
                }
            }
            return $datos;
        }

        //POST con datos ---> Alta de usuario nuevo
        
        //$datos = decodifacarURL($cadena_datos);
*/
        //Devolver la matriz de objetos usuario con todo los usuarios
        function obtenerUsuarios() {
            require_once 'conexion.php';
            $cadena = $_POST['datos'];
            
            $consulta=DB::run( "SELECT NUMERO_CUENTA, TITULAR, SALDO, INTERES FROM Cuentas WHERE TITULAR LIKE :cadena ", //No coge el JSON, falla conex BD
                [':cadena'=>"%$cadena%"]);
                return $consulta->fetchAll(PDO::FETCH_OBJ);
                //echo $consulta->fetchAll(PDO::FETCH_OBJ);
        }

        
        
            $resultado = obtenerUsuarios();
            $respuesta = json_encode($resultado);
           // decodifacarURL($resultado);
            echo $respuesta;

}



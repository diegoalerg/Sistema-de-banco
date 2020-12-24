<?php
require_once 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$monto = $_POST['cantidad'];
$numero_cuenta = $_POST['cuenta'];
$concepto = $_POST['concepto'];

if (isset($_POST['cantidad'])) {
    
    if ($_POST['movimiento']=='RETIRAR') {
        $resultados = DB::run(
        'SELECT SALDO FROM Cuentas WHERE NUMERO_CUENTA = :cuenta AND BLOQUEADA =0',
        [':cuenta'=> $numero_cuenta] );

        $reg = $resultados->fetch();

            if ( $reg !==false ) {
                //Compruebo si al retirar el saldo es mayor que el monto
                $monto = intval($monto);
                    $resultados = DB::run(
                        ' UPDATE Cuentas SET SALDO = SALDO - :monto WHERE NUMERO_CUENTA = :cuenta AND SALDO >= :monta ',
                        [':monto'=>$monto,':cuenta'=>$numero_cuenta, ':monta'=>$monto]);
                //Comprobacion de la modificacion del registro
                                if($resultados->rowCount()==1) {
                                        $respuesta = 'Retiro realizado satisfactoriamente';
                                        echo json_encode($respuesta);
                                    //SALDO EN EN CUENTAS ACTUALIZADO FALTA CREAR EL REGISTRO EN MOVIMIENTO
                                    $resultados = DB::run(
                                        'INSERT INTO Movimientos ( CANTIDAD, CONCEPTO, CUENTA, FECHA )VALUES ( :cantidad, :concepto, :cuenta, :fecha)',
                                        [':cantidad'=>'-'.$monto,
                                        ':concepto'=>$concepto,
                                        ':cuenta'=>$numero_cuenta,
                                        ':fecha'=>(new Datetime())->format('Y-m-d H:i:s')]);
                                } else {
                                    $respuesta = 'Saldo Insuficiente es menor al monto a retirar';
                                        echo json_encode($respuesta);
                                    
                                }
            } else {
                $respuesta = 'Cuenta bloqueada';
                echo json_encode($respuesta);
                                    
               
            }

    } else { //INGRESANDO DINERO
            //Realizacion de la consulta
            
           
            $resultados = DB::run(
                'UPDATE Cuentas SET SALDO = SALDO + :monto WHERE NUMERO_CUENTA = :cuenta AND BLOQUEADA = 0',
                [':monto'=> $monto, ':cuenta'=> $numero_cuenta]);
            
                    //Comprobacion de la modificacion del registro
                    if ($resultados->rowCount()==1) {
                        $respuesta = 'El saldo se modifica por que la cuenta no esta bloqueada';
                        echo json_encode($respuesta);
                         //SALDO EN EN CUENTAS ACTUALIZADO FALTA CREAR EL REGISTRO EN MOVIMIENTO
        $resultados = DB::run(
            'INSERT INTO Movimientos ( CANTIDAD, CONCEPTO, CUENTA, FECHA )VALUES ( :cantidad, :concepto, :cuenta, :fecha)',
            [':cantidad'=>$monto,
            ':concepto'=>$concepto,
            ':cuenta'=>$numero_cuenta,
            ':fecha'=>(new Datetime())->format('Y-m-d H:i:s')]);
                    } else {
                        $respuesta = 'Cuenta bloqueada';
                        echo json_encode($respuesta);
                        
                    }
        }
 
}

?>
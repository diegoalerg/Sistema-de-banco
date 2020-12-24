<?php
    //IP del servidor
    define('DB_HOST', 'localhost');
    //Identifiador de la base de datos
    define('DB_NAME', 'banco');
    //Identificador de usuario de acceso al servidor
    define('DB_USER', 'root');
    //Contraseña de usuario de acceso al servidor
    define('DB_PASS', '');
    //Codificacion de caracteres empleada
    define('DB_CHAR', 'utf8');

    class DB
    {
            //Atributo estático que almacena uúnico objeto PDP instanciado
            protected static $instance = null;
            protected function __construct() {} 
            protected function __clone() {}
            
            //Metodo de obtencion de objeto PDO
            public static function instance() {

                //Si no existe
                if (self::$instance === null)
                {
                        //Se crea
                        $opt = array(
                                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                        PDO::ATTR_EMULATE_PREPARES => false,
                        );
                        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
                        self::$instance = new PDO($dsn,DB_USER,DB_PASS,$opt);
                }
                //Retorno de instancia PDO creada/existente
                return self::$instance;

            }
            //Metodo estatico para invocacion de metodos de objeto PDO
            public static function __callStatic($method, $args) {
                    //Ejecuta el método estático invocado con los argunmetnos dados
                    //sobre el objeto PDP existente.
                    return call_user_func_array(array(self::instance(), $method), $args);
            }
            //Metodo de ejecucion de consulta parametrizada
            public static function run($sql, $args = []) {
                        $stmt = self::instance()->prepare($sql);
                        $stmt->execute($args);
                        //Retorno de objeto PDOStatement.
                        return $stmt;
            }
    }
    
?>
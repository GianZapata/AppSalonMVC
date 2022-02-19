<?php
namespace Model;

use PDO;

class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $primaryKey = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        
        $statement = self::$db->prepare($query);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        
        // Iterar los resultados
        $array = [];
        foreach ($resultado as $registro) {
            $array[] = static::crearObjeto($registro);
        }
        
        // while($registro = $resultado->fetch_assoc()) {
        //     $array[] = static::crearObjeto($registro);
        // }

        // liberar la memoria
        $statement->closeCursor();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === static::$primaryKey ) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            // $sanitizado[$key] = self::$db->escape_string($value);
            $sanitizado[$key] = $value;
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->{static::$primaryKey})) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all( $columns = ['*'] ) {
        $columns = implode(', ', $columns);                                 
        $query = "SELECT {$columns} FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE " . static::$primaryKey . "  = ${id}";
        // Print primary key        
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${column} = '${value}'";
        $result = self::consultarSQL($query);
        return array_shift( $result );
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos        
        // $atributos = $this->sanitizarAtributos();
        $atributos = $this->atributos();

        // Crear la consulta
        $columnas = implode(', ', array_keys($atributos));
        $valores = ':' . implode(', :', array_keys($atributos));
        $query = "INSERT INTO " . static::$tabla . " ({$columnas}) VALUES ({$valores})";

        // Preparar la consulta       
        $statement = self::$db->prepare($query);

        // Vincular los valores
        $atributosArray = [];
        foreach($atributos as $key => $value) {
            $atributosArray[":{$key}"] = "${value}";
        }

        // Ejecutar la consulta
        $resultado = $statement->execute($atributosArray);

        // Guardar el id
        $this->{static::$primaryKey} = self::$db->lastInsertId();
        
        // Liberar la memoria
        $statement->closeCursor();
        
        // Retornar el resultado
        return $resultado;

        // Insertar en la base de datos
        // $query = " INSERT INTO " . static::$tabla . " ( ";
        // $query .= join(', ', array_keys($atributos));
        // $query .= " ) VALUES (' "; 
        // $query .= join("', '", array_values($atributos));
        // $query .= " ') ";
        // echo $query;
        // return $query;
        // // Resultado de la consulta
        // $resultado = self::$db->query($query);
        // return [
        //     'resultado' =>  $resultado,
        //     'id' => self::$db->insert_id
        // ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->atributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        $atributosArray = [];        
        $atributosArray[":" . static::$primaryKey] = $this->{static::$primaryKey};

        foreach($atributos as $key => $value) {
            $valores[] = "{$key} = :{$key}";
            $atributosArray[":{$key}"] = "${value}";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE " . static::$primaryKey ." = :" . static::$primaryKey;
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $statement = self::$db->prepare($query);
        $statement->execute($atributosArray);
        $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        // $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $query = "DELETE FROM "  . static::$tabla . " WHERE " . static::$primaryKey ." = :" . static::$primaryKey;        
        $resultado = self::$db->prepare($query);        
        $resultado->execute([":" . static::$primaryKey => $this->{static::$primaryKey}]);
        if($resultado->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
        // $resultado = self::$db->query($query);
        // return $resultado;
    }
    
    public function exists() {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . static::$primaryKey . " = :" . static::$primaryKey;
        $statement = self::$db->prepare($query);
        $statement->execute([":" . static::$primaryKey => $this->{static::$primaryKey}]);        
        if($statement->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

}
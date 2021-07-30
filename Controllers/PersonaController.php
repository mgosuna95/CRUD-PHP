<?php

include_once dirname(__FILE__) . '/../DB/PDO_Connect.php';
include_once dirname(__FILE__) . '/../Models/Persona.php';

class PersonaController
{

    public function get_Personas()
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Consultar_Personas;";
            $statement = $pdoConnection->prepare($query);
            $statement->execute();

            $personas = $statement->fetchAll(PDO::FETCH_CLASS, "Persona");

            return $personas;

        } catch (Exception $ms) {
            return "ERROR";
        }
    }

    public function get_Persona($id)
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Consultar_Persona(?);";
            $statement = $pdoConnection->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT, 20);

            if (!$statement) {
                return "Error al buscar el registro";
            } else {
                $statement->execute();
                $persona = $statement->fetchAll(PDO::FETCH_CLASS, "Persona");
                return $persona;
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }
    public function update_Persona($id, $Parameters)
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $nombres = $Parameters["nombre"];
            $direccion = $Parameters["direccion"];
            $edad = $Parameters["edad"];
            $idGenero = $Parameters["genero"];
            $salario = $Parameters["salario"];

            $query = "call Actualizar_Persona(?,?,?,?,?,?);";
            $statement = $pdoConnection->prepare($query);
            $statement->bindParam(1, $nombres, PDO::PARAM_STR, 100);
            $statement->bindParam(2, $direccion, PDO::PARAM_STR, 300);
            $statement->bindParam(3, $edad, PDO::PARAM_INT, 11);
            $statement->bindParam(4, $idGenero, PDO::PARAM_INT, 11);
            $statement->bindParam(5, $salario, PDO::PARAM_STR, 11);
            $statement->bindParam(6, $id, PDO::PARAM_STR, 20);
            if (!$statement) {
                return "Error al actualizar registro";
            } else {
                $statement->execute();
                $statement = null;
                return "Registro actualizado correctamente";
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }

    public function delete_Persona($id)
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Eliminar_Persona(?);";
            $statement = $pdoConnection->prepare($query);
            $statement->bindParam(1, $id, PDO::PARAM_INT, 20);

            if (!$statement) {
                return "Error al eliminar registro";
            } else {
                $statement->execute();
                return "Registro eliminado!";
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }

    public function insert_Persona($Parameters)
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $nombres = $Parameters["nombre"];
            $direccion = $Parameters["direccion"];
            $edad = $Parameters["edad"];
            $idGenero = $Parameters["genero"];
            $salario = $Parameters["salario"];

            $query = "call Insertar_Persona(?,?,?,?,?);";
            $statement = $pdoConnection->prepare($query);
            $statement->bindParam(1, $nombres, PDO::PARAM_STR, 100);
            $statement->bindParam(2, $direccion, PDO::PARAM_STR, 300);
            $statement->bindParam(3, $edad, PDO::PARAM_INT, 11);
            $statement->bindParam(4, $idGenero, PDO::PARAM_INT, 11);
            $statement->bindParam(5, $salario, PDO::PARAM_STR, 10);
            if (!$statement) {
                return "Error al crear el registro";
            } else {
                $statement->execute();
                $statement = null;
                return "Registro creado correctamente";
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }
    public function get_TotalSalarios()
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Consultar_Salarios();";
            $statement = $pdoConnection->prepare($query);

            if (!$statement) {
                return "Error al buscar el registro";
            } else {
                $statement->execute();
                $salarios = $statement->fetch();
                return $salarios;
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }
    public function get_TotalSalariosPromedio()
    {
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Consultar_Salarios_Promedio();";
            $statement = $pdoConnection->prepare($query);

            if (!$statement) {
                return "Error al buscar el registro";
            } else {
                $statement->execute();
                $salarios = $statement->fetch();
                return $salarios;
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }

    public function export_Hoja_EXCEL()
    {

        $personas = $this->get_Personas();
        $tabla = "<table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Direccion</th>
                            <th>Genero</th>
                            <th>Salario</th>
                        </tr>
                    </thead>";

        foreach ($personas as $fila) {
            $tabla .= "<tr>
                        <td>" . $fila->getnombres() . "</td>
                        <td>" . $fila->getEdad() . "</td>
                        <td>" . $fila->getDireccion() . "</td>
                        <td>" . $fila->getGenero() . "</td>
                        <td>" . $fila->getSalario() . "</td>
                    </tr>
                </table>";
        }
        $nombreArchivo = "TABLA_DE_DATOS_TEST.xls";
        header("Content-type: application/xls");
        header("Content-Disposition: attachment; filename=$nombreArchivo");
        echo $tabla;       
    }
}

/*
$persona = new Persona;

if ($fila = $statement->fetch()) {

$persona->setId($fila[0]);
$persona->setNombres($fila[1]);
$persona->setEdad($fila[2]);
$persona->setGenero($fila[3]);
$persona->setIdGenero($fila[4]);
$persona->setSalario($fila[5]);

echo '<pre>';
print_r($persona);
echo  '</pre>';

} else {return "null";}

echo'<script type="text/javascript">
alert("'. $insertResult .'");
</script>';
 */

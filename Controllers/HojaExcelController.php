<?php

include_once dirname(__FILE__) . '/PersonaController.php';

$controllerPersona = new PersonaController();
$personas = $controllerPersona->get_Personas();
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
                </tr>";

}
$tabla .= "</table>";
$nombreArchivo = "TABLA_DE_DATOS_TEST.xls";
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$nombreArchivo");
echo $tabla;
//header("Location: ". $_SERVER['HTTP_REFERER']);

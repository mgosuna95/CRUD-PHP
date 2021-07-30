<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Test Pueblo Bonito</title>

    <?php
include_once dirname(__FILE__) . '/Controllers/PersonaController.php';
include_once dirname(__FILE__) . '/Controllers/GeneroController.php';
session_start();
setlocale(LC_ALL, 'es_MX');

$controllerPersona = new PersonaController();
$controllerGenero = new GeneroController();
$personas = $controllerPersona->get_Personas();
$salariosTotal = $controllerPersona->get_TotalSalarios();
$salariosTotalPromedio = $controllerPersona->get_TotalSalariosPromedio();
$generos = $controllerGenero->get_Generos();
$salariosTotalPromedioPorGeneros = $controllerGenero->get_SalarioPromedioGenero();
$selectValueGen = "";

if (array_key_exists('guardar', $_POST)) 
    insertarPersona();
if (array_key_exists('cargar', $_POST)) 
    cargarPersona();
if (array_key_exists('borrar', $_POST)) 
    eliminarPersona();
if (array_key_exists('modificar', $_POST)) 
    modificarPersona();
if (array_key_exists('buscar', $_POST)) 
    buscarPersona();

function insertarPersona()
{
    $controllerPersona = new PersonaController();
    $insertResult = $controllerPersona->insert_Persona($_POST);
    limpiarVariablesSesion();
    $_SESSION['personasVisibles'] = "";
    header("Refresh:0; url=index.php");
}

function cargarPersona()
{
    $controllerPersona = new PersonaController();
    $selectResult = $controllerPersona->get_Persona($_POST["cargar"]);

    $_SESSION['personaIdSelect'] = $selectResult[0]->getId();
    $_SESSION['personaNombresSelect'] = $selectResult[0]->getNombres();
    $_SESSION['personaEdadSelect'] = $selectResult[0]->getEdad();
    $_SESSION['personaDireccionSelect'] = $selectResult[0]->getDireccion();
    $_SESSION['personaGeneroSelect'] = $selectResult[0]->getIdGenero();
    $_SESSION['personaSalarioSelect'] = $selectResult[0]->getSalario();
}

function eliminarPersona(){
    
    $controllerPersona = new PersonaController();
    $eliminarResult = $controllerPersona->delete_Persona(isset($_SESSION['personaIdSelect']) ? $_SESSION['personaIdSelect'] : "");
    limpiarVariablesSesion();
    global $personas;
    if(count($personas) == 0)
        $_SESSION['personasVisibles'] = null;
    header("Refresh:0; url=index.php");
}

function modificarPersona(){
    $controllerPersona = new PersonaController();
    $insertResult = $controllerPersona->update_Persona(isset($_SESSION['personaIdSelect']) ? $_SESSION['personaIdSelect'] : "" ,$_POST);
    limpiarVariablesSesion();
    global $personas;
    if(count($personas) == 0)
        $_SESSION['personasVisibles'] = null;
    header("Refresh:0; url=index.php");
}

function buscarPersona(){
    if(isset($_SESSION['personasVisibles'])){
        if($_SESSION['personasVisibles'] !=""){
            $_SESSION['personasVisibles'] = "";
        }
        else
            $_SESSION['personasVisibles'] = "hidden";
    }else
        $_SESSION['personasVisibles'] = "";
}

function limpiarVariablesSesion(){
    $_SESSION['personaIdSelect'] = null;
    $_SESSION['personaNombresSelect'] = null;
    $_SESSION['personaEdadSelect'] = null;
    $_SESSION['personaDireccionSelect'] = null;
    $_SESSION['personaGeneroSelect'] = null;
    $_SESSION['personaSalarioSelect'] = null;
    //$_SESSION['personasVisibles'] = null;
}
?>
</head>

<body>
    <div class="d-flex justify-content-center mt-5">
        <!--Formulario datos personas-->
        <form method="post" class="row d-flex justify-content-center mt-5">
            <div class="col-auto">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" class="form-control" pattern="[a-zA-Z ]{1,}" title="Ingresa solo letras"
                    value="<?php echo (isset($_SESSION['personaNombresSelect']) ? $_SESSION['personaNombresSelect'] : ""); ?>"
                    required />
            </div>
            <div class="col-auto">
                <label for="edad">Edad:</label>
                <input type="number" name="edad" class="form-control" class="form-control-plaintext" max="100" min="1"
                    value="<?php echo (isset($_SESSION['personaEdadSelect']) ? $_SESSION['personaEdadSelect'] : ""); ?>"
                    required />
            </div>
            <div class="col-auto">
                <label for="direccion">Direccion:</label>
                <input type="text" name="direccion" class="form-control" class="form-control-plaintext"
                    value="<?php echo (isset($_SESSION['personaDireccionSelect']) ? $_SESSION['personaDireccionSelect'] : ""); ?>"
                    required />
            </div>
            <!--carga generos de la BD-->
            <div class="col-auto">
                <label for="direccion">Genero:</label>
                <select class="form-select" aria-label="Default select example" name="genero"
                    value="<?php echo (isset($_SESSION['personaGeneroSelect']) ? $_SESSION['personaGeneroSelect'] : ""); ?>"
                    required>
                    <option hidden value="">Selecionar...</option>
                    <?php
                        if (isset($_SESSION['personaGeneroSelect'])) {
                            $selectValueGen = $_SESSION['personaGeneroSelect'];
                        }
                        foreach ($generos as $fila) {?>
                    <option value="<?php echo ($fila->getId()); ?>" <?php if ($selectValueGen == $fila->getId()) {
                        echo ("selected");}?>>
                        <?php echo ($fila->getDescripcion()); ?>
                    </option>
                    <?php }?>
                    ?>
                </select>
            </div>
            <div class="col-auto">
                <label for="salario">Salario:</label>
                <input type="number" name="salario" class="form-control" step="0.01" min="0" max="99999999"
                    value="<?php echo (isset($_SESSION['personaSalarioSelect']) ? $_SESSION['personaSalarioSelect'] : ""); ?>"
                    required />
            </div>
            <div class="row d-flex justify-content-center mt-5 mb-5">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                </div>
                <!--Botones de accion-->
                <div class="col-auto">
                    <button type="submit" class="btn btn-success" name="buscar" formnovalidate>Buscar</button>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-info" name="modificar">Modificar</button>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-danger" name="borrar" >Borrar</button>
                </div>
            </div>
        </form>
    </div>
    <!--Tabla de datos-->
    <center>
        <div class="row d-flex justify-content-center">
            <div class="col-3"></div>
            <div class="col-4" <?php echo(isset($_SESSION['personasVisibles']) ? $_SESSION['personasVisibles'] : "hidden");  ?>>
                <form method="post" class="table-responsive">
                    <table class="table table-fit">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Edad</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Genero</th>
                                <th scope="col">Salario</th>
                            </tr>
                        </thead>
                        <?php
                    foreach ($personas as $fila) {
                        ?>

                        <tr>
                            <td><button type="submit" class="btn" name="cargar" value="<?php echo ($fila->getId()); ?>">
                                    <?php echo ($fila->getnombres()); ?>
                                </button></td>
                            <td><button type="submit" class="btn" name="cargar" value="<?php echo ($fila->getId()); ?>">
                                    <?php echo ($fila->getEdad()); ?>
                                </button></td>
                            <td><button type="submit" class="btn" name="cargar" value="<?php echo ($fila->getId()); ?>">
                                    <?php echo ($fila->getDireccion()); ?>
                                </button></td>
                            <td><button type="submit" class="btn" name="cargar" value="<?php echo ($fila->getId()); ?>">
                                    <?php echo ($fila->getGenero()); ?>
                                </button></td>
                            <td><button type="submit" class="btn" name="cargar" value="<?php echo ($fila->getId()); ?>">
                                    <?php echo (number_format($fila->getSalario(),2)); ?>
                                </button></td>
                        </tr>

                        <?php
                    }
                    ?>
                    </table>
                </form>
                    
                <form action="Controllers/HojaExcelController.php" method="post" class="table-responsive">
                    <button type="submit" class="btn btn-success" name="exportar" formnovalidate>Exportar EXCEL</button>
                </form>
                <!--Tabla de salarios-->
                <table class="table table-fit mt-5">
                        <tr>
                            <th ></th>
                            <th scope="row"></th>
                            <?php
                                foreach ($generos as $fila) {
                                ?>
                                    <th><?php echo($fila->getDescripcion()); ?></th>
                                <?php
                                }
                            ?>
                        </tr>
                        <tr>
                            <th scope="row">Totalizado de Salarios</th>
                            <td>$<?php echo(number_format($salariosTotal[0],2)) ?> M.N</td>
                        </tr>
                        <tr>
                            <th scope="row">Salario Promedio General</th>
                            <td>$<?php echo(number_format($salariosTotalPromedio[0],2)) ?> M.N</td>
                        </tr>
                        <tr>
                            <th scope="row">Salario Promedio Por Genero</th>
                            <th></th>
                            <?php
                                foreach ($salariosTotalPromedioPorGeneros as $fila) {
                                ?>
                                    <td>$<?php echo(number_format($fila["PROMEDIO_POR_GENERO"],2)); ?> M.N</td>
                                <?php
                                }
                            ?>
                        </tr>
                    </table>
            </div>
            <div class="col-3"></div>
        </div>
    </center>
</body>

</html>
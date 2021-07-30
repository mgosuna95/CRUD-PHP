<?php

include_once dirname(__FILE__) . '/../DB/PDO_Connect.php';
include_once dirname(__FILE__) . '/../Models/Genero.php';

class GeneroController{

    public function get_Generos(){
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Consultar_Generos;";
            $statement = $pdoConnection->prepare($query);
            $statement->execute();

            $generos = $statement->fetchAll(PDO::FETCH_CLASS, "Genero");

            return $generos;

        } catch (Exception $ms) {
            return "ERROR";
        }
    }

    public function get_SalarioPromedioGenero(){
        try {
            $Con = new PDO_Connextion();
            $pdoConnection = $Con->get_connetion();

            $query = "call Consultar_Salario_Promedio_Por_Genero();";
            $statement = $pdoConnection->prepare($query);

            if(!$statement)
            {
                return "Error al buscar el registro";
            }
            else{
                $statement->execute();
                $salarios = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $salarios;
            }
        } catch (Exception $ms) {
            return "ERROR";
        }
    }
}
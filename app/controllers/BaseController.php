<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Devuelvel la fecha larga en español
     * @param  string $datetime
     * @return string Fecha larga en español
     */
    public static function fechaLarga($datetime)
    {
        $fecha = strtotime($datetime);

        $dia = date("d", $fecha);
        $mes = date("F", $fecha);
        $year = date("Y", $fecha);

        if ($mes=="January") $mes="Enero";
        if ($mes=="February") $mes="Febrero";
        if ($mes=="March") $mes="Marzo";
        if ($mes=="April") $mes="Abril";
        if ($mes=="May") $mes="Mayo";
        if ($mes=="June") $mes="Junio";
        if ($mes=="July") $mes="Julio";
        if ($mes=="August") $mes="Agosto";
        if ($mes=="September") $mes="Setiembre";
        if ($mes=="October") $mes="Octubre";
        if ($mes=="November") $mes="Noviembre";
        if ($mes=="December") $mes="Diciembre";

        return $mes .' '. $dia .' de '. $year;

    } #fechaLarga

} #BaseController
<?php

class Utilities
{
	var $cx;
	var	$sql;
	var	$result;
	var	$db;
	var $innerarray;
	var $warnings;

	function Utilities()
	{
		$this->cx=new Conexion();
		$this->db=$this->cx->conectar();

	}

	function validateSession($role) {
		session_start();
		if ( isset ( $_SESSION['role'] )){
			if( $_SESSION['role'] != $role) {
				header("location:Restricted.php");
			}
		}
		else
			header("location:Restricted.php");
	}

	function fillDropDown($dropDownField)
	{
		$this->result = $this->db->Execute("SELECT cc_descripcion_fld, cc_valor_fld FROM cc_valores_tbl WHERE cc_campo_fld = '" . $dropDownField . "' AND cc_estado_fld = 'A'");
		$innerarray = array();
		array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		while ($row = $this->result->FetchRow())
		{
			array_push($innerarray, array ('value' => $row["cc_valor_fld"], 'label' => $row["cc_descripcion_fld"],));
		}
		return $innerarray;
	}

	function fillDropDownVew($dropDownField, $selected)
	{
		$this->result = $this->db->Execute("SELECT cc_descripcion_fld, cc_valor_fld FROM cc_valores_tbl WHERE cc_campo_fld = '" . $dropDownField . "' AND cc_estado_fld = 'A'");
		$innerarray = array();
		if($selected == '') {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		}
		else {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,));
		}
		while ($row = $this->result->FetchRow())
		{
			if($row["cc_valor_fld"] == $selected) {
				array_push($innerarray, array ('value' => $row["cc_valor_fld"], 'label' => $row["cc_descripcion_fld"], 'selected' => true));
			}
			else {
				array_push($innerarray, array ('value' => $row["cc_valor_fld"], 'label' => $row["cc_descripcion_fld"],));
			}
		}
		return $innerarray;
	}

	function fillDropDownState()
	{
		$this->result = $this->db->Execute("SELECT cc_codigodept_fld, cc_descripc_fld FROM cc_departamento_tbl");
		$innerarray = array();
		array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		while ($row = $this->result->FetchRow())
		{
			array_push($innerarray, array ('value' => $row["cc_codigodept_fld"], 'label' => $row["cc_descripc_fld"],));
		}
		return $innerarray;
	}

	function fillDropDownStateVew($selected)
	{
		$this->result = $this->db->Execute("SELECT cc_codigodept_fld, cc_descripc_fld FROM cc_departamento_tbl");
		$innerarray = array();
		if($selected == '') {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		}
		else {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,));
		}
		while ($row = $this->result->FetchRow())
		{
			if($row["cc_codigodept_fld"] == $selected) {
				array_push($innerarray, array ('value' => $row["cc_codigodept_fld"], 'label' => $row["cc_descripc_fld"], 'selected' => true));
			}
			else {
				array_push($innerarray, array ('value' => $row["cc_codigodept_fld"], 'label' => $row["cc_descripc_fld"],));
			}
		}
		return $innerarray;
	}

	function fillDropDownCity($state)
	{
		if($state != '') {
			$this->result = $this->db->Execute("SELECT cc_codciudad_fld, cc_descripc_fld FROM cc_ciudad_tbl WHERE cc_codigodept_fld = '".$state."'");
		}
		else {
			$this->result = $this->db->Execute("SELECT cc_codciudad_fld, cc_descripc_fld FROM cc_ciudad_tbl");
		}
		$innerarray = array();
		array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		while ($row = $this->result->FetchRow())
		{
			array_push($innerarray, array ('value' => $row["cc_codciudad_fld"], 'label' => $row["cc_descripc_fld"],));
		}
		return $innerarray;
	}

	function fillDropDownCityVew($state, $selected)
	{
		if($state != '') {
			$this->result = $this->db->Execute("SELECT cc_codciudad_fld, cc_descripc_fld FROM cc_ciudad_tbl WHERE cc_codigodept_fld = '".$state."'");
		}
		else {
			$this->result = $this->db->Execute("SELECT cc_codciudad_fld, cc_descripc_fld FROM cc_ciudad_tbl");
		}
		$innerarray = array();
		if($selected == '') {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		}
		else {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,));
		}
		while ($row = $this->result->FetchRow())
		{
			if($row["cc_codciudad_fld"] == $selected) {
				array_push($innerarray, array ('value' => $row["cc_codciudad_fld"], 'label' => $row["cc_descripc_fld"], 'selected' => true));
			}
			else {
				array_push($innerarray, array ('value' => $row["cc_codciudad_fld"], 'label' => $row["cc_descripc_fld"],));
			}
		}
		return $innerarray;
	}

	function fillDropDownModel()
	{
		$i = 0;
		date_default_timezone_set('UTC');
		$date = date('Y')+20;
		$innerarray = array();
		array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		while ($i <= 100)
		{
			array_push($innerarray, array ('value' => ($date - $i), 'label' => ($date - $i),));
			$i++;
		}
		return $innerarray;
	}

	function fillDropDownModelVew($selected)
	{
		$i = 0;
		date_default_timezone_set('UTC');
		$date = date('Y')+20;
		$innerarray = array();
		if($selected == '') {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		}
		while ($i <= 100)
		{
			if(($date - $i) == $selected) {
				array_push($innerarray, array ('value' => ($date - $i), 'label' => ($date - $i), 'selected' => true));
			}
			else {
				array_push($innerarray, array ('value' => ($date - $i), 'label' => ($date - $i),));
			}
			$i++;
		}
		return $innerarray;
	}

	function fillDropDownValue()
	{
		$this->result = $this->db->Execute("SELECT cc_campo_fld, cc_descripcion_fld FROM cc_fields_tbl");
		$innerarray = array();
		array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		while ($row = $this->result->FetchRow())
		{
			array_push($innerarray, array ('value' => $row["cc_campo_fld"], 'label' => $row["cc_descripcion_fld"],));
		}
		return $innerarray;
	}

	function fillDropDownValueVew($selected)
	{
		$this->result = $this->db->Execute("SELECT cc_campo_fld, cc_descripcion_fld FROM cc_fields_tbl");
		$innerarray = array();
		if($selected == '') {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,'selected' => true,));
		}
		else {
			array_push($innerarray, array ('value' => '','label' => ' - Seleccione - ','disabled' => false,));
		}
		while ($row = $this->result->FetchRow())
		{
			if($row["cc_campo_fld"] == $selected) {
				array_push($innerarray, array ('value' => $row["cc_campo_fld"], 'label' => $row["cc_descripcion_fld"], 'selected' => true));
			}
			else {
				array_push($innerarray, array ('value' => $row["cc_campo_fld"], 'label' => $row["cc_descripcion_fld"],));
			}
		}
		return $innerarray;
	}

	function findMenu($page) {

		$this->menu= $this->db->Execute("SELECT A.cc_type_fld, A.cc_url_fld ,B.cc_nombre_fld FROM  cc_navegacion_tbl A , cc_imagenes_tbl B WHERE   A.cc_type_fld  = B.cc_identificador_fld AND  A.cc_page_fld ='$page' ORDER BY B.cc_prioridad_fld");

		return $this->menu;
	}

	function sessionStart($login,$password)	{


		$password=md5($password);
		$this->db=$this->cx->conectar();
		$this->result = $this->db->Execute("SELECT cc_role_fld AS role, cc_estado_fld AS state FROM cc_user_tbl WHERE cc_user_id_fld='$login' AND cc_psswrd_fld='$password'");
		$this->cx->desconectar();
		if($this->result) {
			$permiso = $this->result->FetchRow();
		}
		else {
			$permiso = null;
		}
		return $permiso;
	}

	function getDataGrid($gridName, $tableName, $query){

	    $path='/Transporto';
		$g = new jqgrid();
		$grid["caption"] = $gridName;
		$grid["multiselect"] = false;
		$grid["resizable"] = true;
		$grid["rowNum"] = 30;
		$grid["altRows"] = true;
		$grid["autowidth"] = true;
	    //$grid["sortname"] = 'Numero_Documento';
	    $grid["sortorder"] = "desc";  // ASC or DESC
	    //$grid["width"] = "1200";
	    $grid["height"] = "250";
		$describeTable =' DESCRIBE '.$tableName;
		$this->campos = $this->db->Execute($describeTable);
		$i=1;
		while ($row = $this->campos->FetchRow())
		{
			$col = array();
			$col["title"] =  str_replace ('_',' ',$row[0]);
			$col["name"] =  $row[0];
			$col["search"] = true;
			$col["autowidth"] = true;
			switch($gridName) {
				case 'Clientes':
					if ($i == 2) {
						$col["link"] = $path."/Pages/PassThrough.php?Page=Customer_srch&Numero_Documento={Numero_Documento}&Tipo_Identificacion={Tipo_Identificacion}";
					}
					break;
				case 'Propietarios & Conductores':
					if ($i == 2)
						$col["link"] = $path."/Pages/PassThrough.php?Page=Transporter_srch&Numero_Documento={Numero_Documento}&Tipo_Identificacion={Tipo_Identificacion}";
					break;
				case 'Vehiculos':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=Vehicle_srch&Placa={Placa}";
					break;
				case 'Documentos':
					if ($i == 4)
						$col["link"] = $path."/Pages/PassThrough.php?Page=Document_srch&Numero={Numero}&Placa={Placa}&Documento={Documento}";
					break;
				case 'Viajes Ocacionales':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=CasualTravel_srch&Consecutivo={Consecutivo}";
					break;
				case 'Extracto Contratos':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=ContractExtract_srch&Consecutivo={Consecutivo}";
					break;
				case 'Usuarios':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=User_srch&Usuario={Usuario}";
					break;
				case 'Valores':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=Value_srch&Campo={Campo}&Valor={Valor}";
					break;
				case 'Contrato':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=Contract_srch&Consecutivo={Consecutivo}";
					break;
				case 'FUEC':
					if ($i == 1)
						$col["link"] = $path."/Pages/PassThrough.php?Page=PrintFuec&Numero_FUEC={Numero_FUEC}";
					break;
				case 'Ocupantes del FUEC':
					if ($i == 1) {
						$col["width"] = "0";
					}
					if ($i == 3)
						$col["link"] = $path."/Pages/PassThrough.php?Page=FuecPassenger_srch&Numero_Identificacion={Numero_Identificacion}";
					break;
				case 'Mantenimientos Vehiculares':
					if ($i == 1) {
						$col["width"] = "0";
					}
					if ($i == 3)
						$col["link"] = $path."/Pages/PassThrough.php?Page=Maintenance_srch&ID={Identificador}";
					break;
			}
			//$col["width"] = "15";
			$col["editable"] = false;
			$col["align"] = "center";
			$cols[] = $col;
			$i=$i+1;
		}

		$g->select_command = $query;
		$g->set_columns($cols);


		$g->set_options($grid);


		$g->set_actions(array(
					"add"=>false, // allow/disallow add
					"edit"=>false, // allow/disallow edit
					"delete"=>false, // allow/disallow delete
					"rowactions"=>false, // show/hide row wise edit/del/save option
					"search" => "advance", // show single/multi field search condition (e.g. simple or advance)
					"export"=>true,
					"autofilter" => false // Filtros
					  )
					);

		//$g->table = $tableName;

		return $g->render("list1");
	}

	function convertirMonto($monto)
	{
	    $maximo = pow(10,9);
		$unidad            = array(1=>"uno", 2=>"dos", 3=>"tres", 4=>"cuatro", 5=>"cinco", 6=>"seis", 7=>"siete", 8=>"ocho", 9=>"nueve");
		$decena            = array(10=>"diez", 11=>"once", 12=>"doce", 13=>"trece", 14=>"catorce", 15=>"quince", 20=>"veinte", 30=>"treinta", 40=>"cuarenta", 50=>"cincuenta", 60=>"sesenta", 70=>"setenta", 80=>"ochenta", 90=>"noventa");
		$prefijo_decena    = array(10=>"dieci", 20=>"veinti", 30=>"treinta y ", 40=>"cuarenta y ", 50=>"cincuenta y ", 60=>"sesenta y ", 70=>"setenta y ", 80=>"ochenta y ", 90=>"noventa y ");
		$centena           = array(100=>"cien", 200=>"doscientos", 300=>"trescientos", 400=>"cuantrocientos", 500=>"quinientos", 600=>"seiscientos", 700=>"setecientos", 800=>"ochocientos", 900=>"novecientos");
		$prefijo_centena   = array(100=>"ciento ", 200=>"doscientos ", 300=>"trescientos ", 400=>"cuantrocientos ", 500=>"quinientos ", 600=>"seiscientos ", 700=>"setecientos ", 800=>"ochocientos ", 900=>"novecientos ");
		$sufijo_miles      = "mil";
		$sufijo_millon     = "un millon";
		$sufijo_millones   = "millones";

		$base         = strlen(strval($monto));
		$pren         = intval(floor($monto/pow(10,$base-1)));
		$prencentena  = intval(floor($monto/pow(10,3)));
		$prenmillar   = intval(floor($monto/pow(10,6)));
		$resto        = $monto%pow(10,$base-1);
		$restocentena = $monto%pow(10,3);
		$restomillar  = $monto%pow(10,6);

		if (!$monto) return "";

	    if ($monto>0 && $monto < abs($maximo))
	    {
			switch ($base) {
				case 1: return $unidad[$monto];
				case 2: return array_key_exists($monto, $decena)  ? $decena[$monto]  : $prefijo_decena[$pren*10]   . $this->convertirMonto($resto);
				case 3: return array_key_exists($monto, $centena) ? $centena[$monto] : $prefijo_centena[$pren*100] . $this->convertirMonto($resto);
				case 4: case 5: case 6: return ($prencentena>1) ? $this->convertirMonto($prencentena). " ". $sufijo_miles . " " . $this->convertirMonto($restocentena) : $sufijo_miles;
				case 7: case 8: case 9: return ($prenmillar>1)  ? $this->convertirMonto($prenmillar). " ". $sufijo_millones . " " . $this->convertirMonto($restomillar)  : $sufijo_millon. " " . $this->convertirMonto($restomillar);
			}
	    } else {
	        $texto= "ERROR con el numero - $monto<br/> Debe ser un numero entero menor que " . number_format($maximo, 0, ".", ",") . ".";
	    }
	    return $texto;
	}

    function SeparFechas($fecha)
    {
    	preg_match("/(\d{4})-(\d{2})-(\d{2})/", $fecha, $fechaArray);

		return $fechaArray;
    }

	function mes($num){

	    $meses = array('Error', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
	        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

	    $num_limpio = $num >= 1 && $num <= 12 ? intval($num) : 0;
	    return $meses[$num_limpio];
	}

	function fechaATexto($fecha, $formato = 'c') {

	    if (preg_match("/(\d{4})-(\d{2})-(\d{2})/", $fecha, $partes)) {

	        $mes = ' de ' .  $this->mes($partes[2]) . ' de ';
	        if ($formato == 'u') {
	            $mes = strtoupper($mes);
	        } elseif ($formato == 'l') {
	            $mes = strtolower($mes);
	        }
	        return $partes[3] . $mes . $partes[1];

	    }
	    else {
	        return 'Formato Incorrecto de Fecha';
	    }
	}


	function timestampATexto($timestamp, $formato = 'c') {


	    if (strpos($timestamp, " ") === false){
	        return false;
	    }

	    $timestamp = explode(" ", $timestamp);

	    if ( $this->fechaATexto($timestamp[0])) {
	        $conjuncion = ' a las ';
	        if ($formato == 'u') {
	            $conjuncion = strtoupper($conjuncion);
	        }
	        return $this->fechaATexto($timestamp[0], $formato) . $conjuncion . $timestamp[1];
	    }
	}

	function imprimirWarnings(){

		$this->warnings= $this->db->Execute("select * from cc_warnings_vw");

		echo "<table cellspacing=1 border=0 style='font-size:13px;background-color:white;'>";
		echo "<tr style='background-color:#46871e;' >";
		print "<td>Estado</td>
		<td>Documento</td>
		<td>Numero</td>
		<td>Placa</td>
		<td>Identificacion</td>
		<td>Vencimiento</td>
		";
		echo "</tr>";

		while ($row = $this->warnings->FetchRow()){

			echo '<tr>';
				echo '<td>'.$row["Estado"].'</td>';
				echo '<td>'.$row["Documento"].'</td>';
				echo '<td>'.$row["Numero"].'</td>';
				echo '<td>'.$row["Placa"].'</td>';
				echo '<td>'.$row["Identificacion"].'</td>';
				echo '<td>'.$row["Vencimiento"].'</td>';
			echo '</tr>';

		}
		print "</table>";
	}

}
?>
<?php

require_once('Tcpdf/tcpdf_include.php');
include "../Clases/TemplatePage.php";

class TemplateReport
{
	var $pdf;
	var $util;
	var $result;

	function TemplateReport($reporte,$orientacion,$tamano, $validateSession, $role)
	{
		$this->util = new Utilities();

		$this->pdf = new TCPDF($orientacion, PDF_UNIT, $tamano, true, 'UTF-8', false);

		$this->pdf->SetCreator('TRANSCORVALLE');
		$this->pdf->SetAuthor('TRANSCORVALLE');
		$this->pdf->SetTitle('Orden de Servicio');
		$this->pdf->SetSubject('Orden de Servicio');
		$this->pdf->SetKeywords('Transcorvalle,'.$reporte.',Especiales y turismo');
		if($validateSession) {
			$this->util->validateSession($role);
		}
	}

	function setupForm($reporte,$background,$encabezado,$firma,$firmaConductor,$piePagina){


		if ($reporte == 'Extracto de Contrato' || $reporte == 'Contrato'){

			$wb =20;
			$xb =55;
			$yb =180;
			$zb =200;

			$yf =270;

		}

		if ($reporte == 'FUEC'){

			$wb =20;
			$xb =55;
			$yb =180;
			$zb =200;

			$yf =320;
		}

		if ($reporte == 'Orden de Servicio'){

			$wb =20;
			$xb =20;
			$yb =150;
			$zb =200;

			$yf =150;
		}


		$this->pdf->AddPage();
		$bMargin = $this->pdf->getBreakMargin();
		$auto_page_break = $this->pdf->getAutoPageBreak();
		$this->pdf->SetAutoPageBreak(false, 0);


		if ($background)
			$this->pdf->Image(K_PATH_IMAGES.'FondoReporte.png', $wb, $xb, $yb, $zb, '', '', '', false, 0, '', false, false, 0);


		if ($encabezado){
			$this->pdf->Image(K_PATH_IMAGES.'Logo.png', 10,5, 50, 0, '', '', '', false, 0);
			$this->pdf->Image(K_PATH_IMAGES.'tituloReporte.png', 150,22, 55, 0, '', '', '', false, 0);
			$this->pdf->Image(K_PATH_IMAGES.'supertransporte.jpg', 150,10, 40,10, '', '', '', false, 0);
			$this->pdf->Image(K_PATH_IMAGES.'incontec.jpg', 195,5,10,0, '', '', '', false, 0);
		}

		if ($firma)
			$this->pdf->Image(K_PATH_IMAGES.'firmaSello.png', 40,110,50,0, '', '', '', false, 0);

		if ($firmaConductor)
			$this->pdf->Image(K_PATH_IMAGES.'firmaConductor.png',120,110,50,0, '', '', '', false, 0);

		if ($piePagina)
			$this->pdf->Image(K_PATH_IMAGES.'piePagina.png', 50,$yf,120,0, '', '', '', false, 0);



		$this->pdf->SetAutoPageBreak($auto_page_break, $bMargin);
	}

	function exportarPdf($id){
		$this->pdf->Output($id.'pdf', 'I');
	}
	function serviceOrder($tamanoFuenteForm,$objetoS,$persona,$celular,$direcO,$direcD,$salida,$regreso,$conductor,$placa,$consecutivo)
	{

		$salida=$this->util->timestampATexto($salida,'u');
		$regreso=$this->util->timestampATexto($regreso,'u');

		$this->pdf->Ln(25);

		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm+2); $this->pdf->Cell(0, 5, $consecutivo, 0, 1, 'R');
		$this->pdf->SetFont('helvetica', 'BU', $tamanoFuenteForm+4); $this->pdf->Cell(0, 5, 'ORDEN DE SERVICIO	', 0, 1, 'C');

		$this->pdf->Ln(5);

		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'OBJETO DEL SERVICIO: ');$this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $objetoS);
		$this->pdf->Ln(4);

		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'PERSONA ENCARGADA DEL SERVICIO:'); $this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $persona);

		$this->pdf->Ln(4);
		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'CELULAR No:');$this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $celular);

		$this->pdf->Ln(7);
		$this->pdf->SetFont('helvetica', 'BIU', $tamanoFuenteForm);$this->pdf->Cell(0, 5, 'UBICACIÓN DE ORIGEN Y DESTINO:', 0, 1, 'L');


		$this->pdf->Ln(2);
		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'DIRECCION DE ORIGEN:'); $this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $direcO);
		$this->pdf->Ln(4);
		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'DIRECCION DE DESTINO:');$this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $direcD);


		$this->pdf->Ln(8);
		$this->pdf->SetFont('helvetica', 'BIU', $tamanoFuenteForm);$this->pdf->Cell(0, 5, 'FECHA Y HORA:', 0, 1, 'L');
		$this->pdf->Ln(2);
		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'SALIDA:'); $this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $salida);
		$this->pdf->Ln(4);
		$this->pdf->SetFont('helvetica', 'B', $tamanoFuenteForm);  $this->pdf->Cell(60, 5, 'REGRESO:'); $this->pdf->SetFont('helvetica', '', $tamanoFuenteForm);  $this->pdf->Cell(0, 1, $regreso);

		$this->pdf->Ln(5);

		$this->pdf->SetFont('helvetica', 'BI', $tamanoFuenteForm-1); $this->pdf->Cell(60, 5, 'NOTA:  El vehículo con  placa '.$placa.' conducido por '.$conductor.' debe estar en perfecto estado Mecánico y de aseo.');

	}

	function OcacionalTravel($consecutivo,$objetoS,$numeroDoc,$placa,$numPas,$busesCon,$fechasalida,$fecharegreso,$horasalida,$horaregreso,$origen,$destino,$direSalida,$conductor1,$conductor2){

	    $this->result = $this->util->db->Execute("SELECT cc_identificador_fld,cc_fecha_ven_fld,cc_nombre_ase_fld FROM cc_documento_tbl WHERE cc_placa_fld ='$placa' and  cc_tipo_docum_fld =04;");

		if($this->result) {
			$idSeguOb=$this->result->fields[0];
			if($idSeguOb == '') {$idSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$fecSeguOb=$this->result->fields[1];
			if($fecSeguOb == '') {
				$fecSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			//else {
				//$fecSeguOb = $this->util->fechaATexto($fecSeguOb);
			//}
			$nomSeguOb=$this->result->fields[2];
			if($nomSeguOb == '') {$nomSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$idPoliza='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$fecPoliza='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$nomPoliza='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT cc_identificador_fld,cc_fecha_ven_fld,cc_nombre_ase_fld FROM cc_documento_tbl WHERE cc_placa_fld ='$placa' and  cc_tipo_docum_fld =05;");

		if($this->result) {
			$idPoliza=$this->result->fields[0];
			if($idPoliza == '') {$idPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$fecPoliza=$this->result->fields[1];
			if($fecPoliza == '') {
				$fecPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			//else {
			//	$fecPoliza = $this->util->fechaATexto($fecPoliza);
			//}
			$nomPoliza=$this->result->fields[2];
			if($nomPoliza == '') {$nomPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$idPoliza='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$fecPoliza='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$nomPoliza='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT  Nombre,Ciudad,Direccion,CONCAT(Telefono,'-' , Celular ) FROM  cc_customer_vw WHERE   Numero_Documento='$numeroDoc'");

		if($this->result) {
			$nombreCLiente=$this->result->fields[0];
			if($nombreCLiente == '') {$nombreCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$ciudadCLiente=$this->result->fields[1];
			if($ciudadCLiente == '') {$ciudadCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$direccionCLiente=$this->result->fields[2];
			if($direccionCLiente == '') {$direccionCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$telefonoCLiente=$this->result->fields[3];
			if($telefonoCLiente == '') {$telefonoCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$nombreCLiente='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$ciudadCLiente='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$direccionCLiente='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$telefonoCLiente='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT (select cc_descripcion_fld from cc_valores_tbl where cc_campo_fld = 'cc_clase_fld' and cc_valor_fld = cc_clase_fld ),(select cc_descripcion_fld from cc_valores_tbl where cc_campo_fld = 'cc_marca_fld' and cc_valor_fld = cc_marca_fld ),cc_modelo_fld,cc_codigoInterno_fld from cc_vehicle_tbl where cc_placa_fld='$placa'");

		if($this->result) {
			$clase=$this->result->fields[0];
			if($clase == '') {$clase = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$marca=$this->result->fields[1];
			if($marca == '') {$marca = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$modelo=$this->result->fields[2];
			if($modelo == '') {$modelo = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$numeroI=$this->result->fields[3];
			if($numeroI == '') {$numeroI = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$clase='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$marca='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$modelo='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$numeroI='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT PC.CC_NUME_DOC_FLD, P.CC_FNOMBRE_FLD FROM CC_PERSON_TBL P INNER JOIN CC_PROPCOND_TBL PC ON P.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE P.CC_NUME_DOC_FLD = '$conductor1'");

		if($this->result) {
			$cedulaCondu=$this->result->fields[0];
			if($cedulaCondu == '') {$cedulaCondu = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$nombreCondu=$this->result->fields[1];
			if($nombreCondu == '') {$nombreCondu = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$cedulaCondu = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$nombreCondu = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT PC.CC_NUME_DOC_FLD, P.CC_FNOMBRE_FLD FROM CC_PERSON_TBL P INNER JOIN CC_PROPCOND_TBL PC ON P.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE P.CC_NUME_DOC_FLD = '$conductor2'");

		if($this->result) {
			$cedulaCondu2=$this->result->fields[0];
			if($cedulaCondu2 == '') {$cedulaCondu2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$nombreCondu2=$this->result->fields[1];
			if($nombreCondu2 == '') {$nombreCondu2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$cedulaCondu2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$nombreCondu2 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT CC_DESCRIPC_FLD FROM CC_CIUDAD_TBL WHERE CC_CODCIUDAD_FLD = (SELECT CC_CODCIUDAD_FLD FROM CC_PERSON_TBL WHERE CC_NUME_DOC_FLD = '$numeroDoc')");

		if($this->result) {
			$ciudadExp=$this->result->fields[0];
			if($ciudadExp == '') {$ciudadExp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$ciudadExp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		if($fechasalida == '') {
			$fechasalida = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		//else {
		//	$fechasalida = $this->util->fechaATexto($fechasalida);
		//}
		if($fecharegreso == '') {
			$fecharegreso = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		//else {
		//	$fecharegreso = $this->util->fechaATexto($fecharegreso);
		//}

		$this->pdf->Ln(30);

		//$this->pdf->SetFont('helvetica', 'B', 8); $this->pdf->Cell(0, 5, $consecutivo, 0, 1, 'R');

		$this->pdf->Ln(9);



		$html1 = <<<EOD

			<table border="0" cellspacing="0" cellpadding="0" >
				<tbody>
				<tr>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" colspan="4" valign="bottom" ></td>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" colspan="2" valign="bottom" ></td>
					<td nowrap="" colspan="2" valign="bottom" border="1"><p><b>$consecutivo</b></p></td>
				</tr>

				<tr>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" colspan="4" valign="bottom" ></td>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" colspan="2" valign="bottom" ></td>
					<td nowrap="" valign="bottom" ></td>
					<td nowrap="" valign="bottom" ></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><div align="center"><font face="Arial" size="11"><b>EXTRACTO DE CONTRATO</b></font></div></p></td>
				</tr>


				<tr>
					<td nowrap="" colspan="11" valign="bottom"  border="1"><p><div align="center"><font face="Arial" size="11"><b>DECRETO 174 - ARTICULO 23 DE FEBRERO 5 DE 2001 </b></font></div></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><div align="center"><font face="Arial" size="11"><b>DATOS POLIZAS DE SEGUROS </b></font></div></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="8" valign="bottom"  border="1"><p><font face="Arial" size="11"><b>SEGURO OBLIGATORIO No: </b> $idSeguOb</font></p></td>
					<td nowrap="" colspan="3" valign="bottom"  border="1"><p><font face="Arial" size="11"> <b>VENCE:</b> $fecSeguOb</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom"  border="1"><p><font face="Arial" size="11"><b>COMPAÑIA DE SEGURO:</b> $nomSeguOb</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="8" valign="bottom"  border="1"><p><font face="Arial" size="11"><b>POLIZA CONTRACTUAL Y EXTRACONTRACTUAL No:</b> $idPoliza</font></p></td>
					<td nowrap="" colspan="3" valign="bottom"  border="1"><p><font face="Arial" size="11"> <b>VENCE: </b> $fecPoliza</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom"   border="1"><p><font face="Arial" size="11"><b>COMPAÑIA DE SEGURO:</b> $nomPoliza</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom"  border="1"><p><font face="Arial" size="11"><b>OBJETO DEL CONTRATO:</b> $objetoS </font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom"  border="1"><p><font face="Arial" size="11"><b>ORIGEN:</b> $origen</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>DESTINO:</b> $destino</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>PERSONA O EMPRESA QUE CONTRATA EL SERVICIO:</b> $nombreCLiente </font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>C.C. O NIT:</b> $numeroDoc</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>CIUDAD:</b> $ciudadCLiente</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>DIRECCION:</b> $direccionCLiente</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>TELEFONO:</b> $telefonoCLiente</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="5" valign="bottom" border="1"></td>
					<td nowrap="" colspan="2" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>FECHA SALIDA</b></font></div></td>
					<td nowrap="" colspan="4" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>FECHA REGRESO</b></font></div></td>
				</tr>

				<tr>
					<td nowrap="" colspan="5" valign="bottom" border="1"></td>
					<td nowrap="" colspan="2" valign="bottom" border="1"><div align="center"><font face="Arial" size="11"><br>$fechasalida</div></font></td>
					<td nowrap="" colspan="4" valign="bottom" border="1"><div align="center"><font face="Arial" size="11"><br>$fecharegreso</div></font></td>
				</tr>

				<tr>
					<td nowrap="" colspan="11" valign="bottom" border="1"><p><font face="Arial" size="11"><b>NUMERO DE PASAJEROS:</b> $numPas</font></p></td>
				</tr>

				<tr>
				<td nowrap="" colspan="11" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>DATOS DEL VEHICULO</b></font></div></td>
				</tr>

				<tr>
					<td nowrap="" colspan="2" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>PLACA</b></font></div></td>
					<td nowrap="" colspan="3" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>CLASE</b></font></div></td>
					<td nowrap="" colspan="2" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>MARCA</b></font></div></td>
					<td nowrap="" colspan="3" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>MODELO</b></font></div></td>
					<td nowrap="" valign="bottom" border="1"><div align="center"><font face="Arial" size="10"><b>No. INTERNO</b></font></div></td>
				</tr>

				<tr>
					<td nowrap=""  colspan="2" border="1"><div align="center"><font face="Arial" size="11">$placa</font></div></td>
					<td nowrap="" colspan="3"  border="1"><div align="center"><font face="Arial" size="11">$clase</font></div></td>
					<td nowrap="" colspan="2"  border="1"><div align="center"><font face="Arial" size="11">$marca</font></div></td>
					<td nowrap="" colspan="3"  border="1"><div align="center"><font face="Arial" size="11">$modelo</font></div></td>
					<td nowrap=""  border="1"><div align="center"><font face="Arial" size="11">$numeroI</font></div></td>
				</tr>

				<tr>
					<td nowrap="" colspan="3"  border="1" height="1%"><p><font face="Arial" size="11"><b>Nombre del Conductor:</b></font></p></td>
					<td nowrap="" colspan="4"  border="1" ><p><font face="Arial" size="11"> $nombreCondu</font></p></td>
					<td nowrap="" colspan="2"  border="1"><p><font face="Arial" size="11"><b>C.C.</b></font></p></td>
					<td nowrap="" colspan="2" border="1" ><p><font face="Arial" size="11"> $cedulaCondu</font></p></td>
				</tr>

				<tr>
					<td nowrap="" colspan="3"  border="1" height="1%"><p><font face="Arial" size="11"><b>Nombre del Conductor 2:</b></font></p></td>
					<td nowrap="" colspan="4"  border="1" ><p><font face="Arial" size="11"> $nombreCondu2</font></p></td>
					<td nowrap="" colspan="2"  border="1"><p><font face="Arial" size="11"><b>C.C.</b></font></p></td>
					<td nowrap="" colspan="2" border="1" ><p><font face="Arial" size="11"> $cedulaCondu2</font></p></td>
				</tr>

				</tbody>
			</table>



EOD;


		$this->pdf->writeHTML($html1, true, false, true, false, '');


		$this->pdf->AddPage();

		$this->pdf->Ln(160);


		$html2 = <<<EOD

		<div align="center"><p><font face="Arial" size="10"><b>CONTRATO DE TRANSPORTE</b></font></p></div>

		<div align="justify">
		<p><font face="Arial" size="9">Conste por el presente documento, que entre los suscritos a saber <b>$nombreCLiente</b> C.C.  No. <b>$numeroDoc</b> De <b>$ciudadExp</b>, quien para efectos del presente se denominará CONTRATANTE,
		y el señor <b>CARLOS ARTURO GONZALEZ C.</b> C.C. No. <b>16,341,354</b> de <b>TULUA</b> , quien para efectos del mismo se denominará CONTRATISTA, hemos celebrado el presente contrato de transporte, estipulado con las siguientes cláusulas:
		<b>PRIMERA:</b> EL CONTRATISTA se compromete a facilitar un vehículo para transporte de pasajeros afiliado a <b>TRANSCORVALLE S.A.S</b>, en la siguiente forma:
		ORIGEN <b>$origen</b> DESTINO <b>$destino</b> No. BUSES CONTRATADOS <b>$busesCon</b>
		DIRECCION SALIDA <b>$direSalida</b> HORA SALIDA <b>$horasalida</b> HORA REGRESO <b>$horaregreso</b>	FECHA DE SALIDA <b>$fechasalida</b> FECHA DE REGRESO <b>$fecharegreso</b>
		PLACA <b>$placa</b> MARCA <b>$marca</b> MODELO <b>$modelo</b> No. PASAJEROS <b>$numPas</b> No. INTERNO <b>$numeroI</b>. <b>SEGUNDA</b>: EL CONTRATISTA se compromete con el CONTRATANTE a realizar un viaje en plan de excursión a los siguientes sitios: <b>$destino</b>. EL CONTRATISTA entregará a la
		disponibilidad del CONTRATANTE los puestos del vehículo, sin sobrepasar el cupo permitido de su capacidad y el CONTRATANTE respetará el puesto auxiliar.

		</font></p></div>


EOD;
		$this->pdf->writeHTML($html2, true, false, true, false, '');

		$this->pdf->Image(K_PATH_IMAGES.'firmaContratista.png', 40,260,50,0, '', '', '', false, 0);
		$this->pdf->Image(K_PATH_IMAGES.'firmaContratante.png',120,260,50,0, '', '', '', false, 0);


	}

	function contractExtract ($consecutivo,$numeroDoc,$duracion,$origen,$destino,$objeto,$placa,$escolar)
	{

		$this->result = $this->util->db->Execute("SELECT  Nombre FROM  cc_customer_vw WHERE   Numero_Documento='$numeroDoc'");

		if($this->result) {
			$nombreCLiente=$this->result->fields[0];
			if($nombreCLiente == '') {$nombreCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$nombreCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT (select cc_descripcion_fld from cc_valores_tbl where cc_campo_fld = 'cc_clase_fld' and cc_valor_fld = cc_clase_fld ),(select cc_descripcion_fld from cc_valores_tbl where cc_campo_fld = 'cc_marca_fld' and cc_valor_fld = cc_marca_fld ),cc_modelo_fld,cc_codigoInterno_fld ,cc_capacidad_fld from cc_vehicle_tbl where cc_placa_fld='$placa'");

		if($this->result) {
			$clase=$this->result->fields[0];
			if($clase == '') {$clase = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$marca=$this->result->fields[1];
			if($marca == '') {$marca = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$modelo=$this->result->fields[2];
			if($modelo == '') {$modelo = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$numeroI=$this->result->fields[3];
			if($numeroI == '') {$numeroI = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$pasajeros=$this->result->fields[4];
			if($pasajeros == '') {$pasajeros = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$clase='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$marca='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$modelo='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$numeroI='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$pasajeros = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}


		$this->result = $this->util->db->Execute("SELECT cc_identificador_fld,cc_fecha_ven_fld,cc_nombre_ase_fld FROM cc_documento_tbl WHERE cc_placa_fld ='$placa' and  cc_tipo_docum_fld =04;");

		if($this->result) {
			$idSeguOb=$this->result->fields[0];
			if($idSeguOb == '') {$idSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$fecSeguOb=$this->result->fields[1];
			if($fecSeguOb == '') {$fecSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$nomSeguOb=$this->result->fields[2];
			if($nomSeguOb == '') {$nomSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$idSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$fecSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$nomSeguOb = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT cc_identificador_fld,cc_fecha_ven_fld,cc_nombre_ase_fld FROM cc_documento_tbl WHERE cc_placa_fld ='$placa' and  cc_tipo_docum_fld =05;");

		if($this->result) {
			$idPoliza=$this->result->fields[0];
			if($idPoliza == '') {$idPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$fecPoliza=$this->result->fields[1];
			if($fecPoliza == '') {$fecPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$nomPoliza=$this->result->fields[2];
			if($nomPoliza == '') {$nomPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$idPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$fecPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$nomPoliza = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT  c.cc_Fnombre_fld,a.cc_nume_doc_fld FROM cc_per_veh_tbl a, cc_propcond_tbl b , cc_person_tbl c WHERE a.cc_tipo_doc_fld = b.cc_tipo_doc_fld AND   a.cc_nume_doc_fld = B.cc_nume_doc_fld AND   b.cc_tipo_doc_fld = c.cc_tipo_doc_fld AND   b.cc_nume_doc_fld = c.cc_nume_doc_fld AND   B.cc_type_pc_fld =01 AND  a.cc_placa_fld='$placa' AND b.cc_type_pc_fld = '01'");

		if($this->result) {
			$nombrePropie=$this->result->fields[0];
			if($nombrePropie == '') {$nombrePropie = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$cedulaPropie=$this->result->fields[1];
			if($cedulaPropie == '') {$cedulaPropie = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$nombrePropie = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$cedulaPropie = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}


	    if ($escolar == 1) {
	    	$textoEscolar = '2. Cumpliendo  con el DECRETO No. 174 DE 5 de febrero de 2001, del Código Nacional de Tránsito';
	    	$textoEscolar .= ' y Transporte, Articulo 28 PROTECCION A LOS ESTUDIANTES: Con el fin de garantizar la protección de los estudiantes, durante todo el recorrido';
			$textoEscolar .= ' en la prestación del servicio de transporte, los vehículos dedicados a este servicio deberán llevar un adulto en representación de la entidad docente.';
		}
		else {
			$textoEscolar = '';
		}

		$html = <<<EOD

			<br><br><br><br><br><br>
			<table border="0" cellspacing="0" cellpadding="0" >
				<tbody>
					<tr>
						<td nowrap="" colspan="6" valign="bottom" ></td>
						<td nowrap="" colspan="4" valign="bottom" ></td>
						<td nowrap="" valign="bottom" ></td>
						<td nowrap="" colspan="3" valign="bottom" ></td>
						<td nowrap="" colspan="2" valign="bottom" ></td>
						<td nowrap="" colspan="4" valign="bottom" ><p><b>$consecutivo</b></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><div align="center"><font face="Arial" size="15"><b><u>EXTRACTO DE CONTRATO</u></b></font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><div align="center"><br>DECRETO 174 - ARTICULO 23 DE FEBRERO 5 DE 2001</div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><br><br></td>
					</tr>

					<tr>
						<td nowrap="" colspan="4" valign="bottom" ><div align="left"><font face="Arial" size="12"><b><u>CONTRATANTE: </u></b></font></div></td>
						<td colspan="16" valign="bottom" ><div align="left"><font face="Arial" size="12">$nombreCLiente</font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="2" valign="bottom" ><div align="left"><font face="Arial" size="12"><b><u>NIT/ C.C:</u></b></font></div></td>
						<td colspan="18" valign="bottom" ><div align="left"><font face="Arial" size="12">$numeroDoc</font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="7" valign="bottom" ><div align="left"><font face="Arial" size="12"><b><u>DURACION DEL CONTRATO:</u></b></font></div></td>
						<td colspan="13" valign="bottom" ><div align="left"><font face="Arial" size="12">$duracion <br></font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="3" valign="bottom" ><div align="left"><font face="Arial" size="12"><b><u>ORIGEN : </u></b></font></div></td>
						<td colspan="17" valign="bottom" ><div align="left"><font face="Arial" size="12">$origen</font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="3" valign="bottom" ><div align="left"><font face="Arial" size="12"><b><u>DESTINO : </u></b></font></div></td>
						<td colspan="17" valign="bottom" ><div align="left"><font face="Arial" size="12">$destino <br></font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="6" valign="top" ><div align="left"><font face="Arial" size="12"><b><u>OBJETO DEL CONTRATO : </u></b></font></div></td>
						<td colspan="14" valign="bottom" ><div align="left"><font face="Arial" size="12">$objeto<br></font></div></td>
					</tr>


					<tr>
					<td nowrap="" colspan="20" valign="bottom" ><div align="left"><font face="Arial" size="12"><b><u>VEHICULO CONTRATADO:</u></b></font></div></td>
					</tr>

					<tr>
						<td nowrap="" colspan="4" valign="bottom" ><p><b>CLASE</b></p></td>
						<td colspan="8" valign="bottom" ><p>$clase</p></td>
						<td colspan="3" valign="bottom" ><p><b>PLACA</b></p></td>
						<td colspan="5" valign="bottom" ><p>$placa</p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="4" valign="bottom" ><p><b>MARCA</b></p></td>
						<td colspan="8" valign="bottom" ><p>$marca</p></td>
						<td colspan="3" valign="bottom" ><p><b>MODELO</b></p></td>
						<td colspan="5" valign="bottom" ><p>$modelo</p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="4" valign="bottom" ><p><b>No. INTERNO</b></p></td>
						<td colspan="8" valign="bottom" ><p>$numeroI</p></td>
						<td colspan="3" valign="bottom" ><p><b>PASAJEROS</b></p></td>
						<td colspan="5" valign="bottom" ><p> $pasajeros</p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><p><br>SERVICIO PÚBLICO ESPECIALES Y DE TURISMO<br></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="6" valign="bottom" ><p><font face="Arial" size="11">SEGURO OBLIGATORIO No. </font></p></td>
						<td colspan="9" valign="bottom" ><p><font face="Arial" size="11">$idSeguOb</font></p></td>
						<td colspan="2" valign="bottom" ><p><font face="Arial" size="11">VENCE</font></p></td>
						<td colspan="3" valign="bottom" ><p><font face="Arial" size="11">$fecSeguOb</font></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="6" valign="bottom" ><p><font face="Arial" size="11">COMPAÑIA DE SEGURO :</font></p></td>
						<td colspan="14" valign="bottom" ><p><font face="Arial" size="11">$nomSeguOb <br></font></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="11" valign="bottom" ><p><font face="Arial" size="11">POLIZA CONTRACTUAL Y EXTRACONTRACTUAL No.</font></p></td>
						<td colspan="4" valign="bottom" ><p><font face="Arial" size="11">$idPoliza</font></p></td>
						<td colspan="2" valign="bottom" ><p><font face="Arial" size="11">VENCE </font></p></td>
						<td colspan="3" valign="bottom" ><p><font face="Arial" size="11">$fecPoliza</font></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="6" valign="bottom" ><p><font face="Arial" size="11">COMPAÑIA DE SEGURO : </font></p></td>
						<td colspan="14" valign="bottom" ><p><font face="Arial" size="11">$nomPoliza <br></font></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="4" valign="bottom" ><p>PROPIETARIO</p></td>
						<td colspan="16" valign="bottom" ><p>$nombrePropie</p></td>
					</tr>

					<tr>
						<td nowrap="" valign="bottom" ><p>C.C.</p></td>
						<td colspan="19" valign="bottom" ><p>$cedulaPropie<br></p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><p><b>NOTA</b>: El vehículo se encuentra:.</p></td>
					</tr>

					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><p><font face="Arial" size="9">1. En perfecto estado mecánico y no lleva sobrecupo. $textoEscolar</font></p></td>
					</tr>
					<tr>
						<td nowrap="" colspan="20" valign="bottom" ><p><b>ESTE EXTRACTO DE CONTRATO NO ES VALIDO SIN EL SELLO SECO.</b></p></td>
					</tr>

				</tbody>
			</table>



			<br><br><br>
			<div align="center"><b>JUAN SEBASTIAN GONZALEZ GUEVARA <br>Subgerente</b></p></div>

EOD;

		$this->pdf->writeHTML($html, true, false, true, false, '');
	}

	function contract ($consecutivo,$contratante,$origen,$destino,$direccionSalida,$horaSalida,$horaRegreso,$fechaSalida,$fechaRegreso,$placa,$numPasjeros,$vehiContra,$abono,$duracion,$total,$fechaFirma)
	{

		$this->result = $this->util->db->Execute("SELECT  Nombre, Tipo_Identificacion FROM  cc_customer_vw WHERE   Numero_Documento='$contratante'");

		if($this->result) {
			$nombreContratante=$this->result->fields[0];
			$tipoDocumento=$this->result->fields[1];

			if($nombreContratante == '') {$nombreCLiente = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$nombreContratante = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$this->result = $this->util->db->Execute("SELECT (select cc_descripcion_fld from cc_valores_tbl where cc_campo_fld = 'cc_marca_fld' and cc_valor_fld = cc_marca_fld ),cc_modelo_fld,cc_codigoInterno_fld  from cc_vehicle_tbl where cc_placa_fld='$placa'");

		if($this->result) {
			$marca=$this->result->fields[0];
			if($marca == '') {$marca = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$modelo=$this->result->fields[1];
			if($modelo == '') {$modelo = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
			$numeroInterno=$this->result->fields[2];
			if($numeroInterno == '') {$numeroInterno = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
		}
		else {
			$marca = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$modelo = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$numeroInterno = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		if($total != 0) {
			$totalLetras = strtoupper($this->util->convertirMonto($total));
			$saldo = $total-$abono;
			$abono = number_format($abono,2, ",", ".");
			$saldo = number_format($saldo,2, ",", ".");
			$total = number_format($total,2, ",", ".");
		}
		else {
			$totalLetras = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$total = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$abono = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$saldo = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		if($fechaSalida != '') {
			$fechaSalida=$this->util->fechaATexto($fechaSalida,'u');
		}
		else {
			$fechaSalida = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		if($fechaRegreso != '') {
			$fechaRegreso=$this->util->fechaATexto($fechaRegreso,'u');
		}
		else {
			$fechaRegreso = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		if($fechaFirma != '') {
			$fechaArray=$this->util->SeparFechas($fechaFirma);

			$diaFirma=(int)$fechaArray[3];
			$mesFirma=strtoupper($this->util->mes($fechaArray[2]));
			$year=(int)$fechaArray[1];

			$diaFirmaString=strtoupper($this->util->convertirMonto($diaFirma));
			$yearString = strtoupper($this->util->convertirMonto($year));
		}
		else {
			$fechaArray = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$diaFirma = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$mesFirma = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$year = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$diaFirmaString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$yearString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}


		$this->pdf->Ln(35);

		$html = <<<EOD

				<p align="center"><font face="Arial" size="11"><b>CONTRATO DE TRANSPORTE</b></font></p>

				<p align="justify"><font face="Arial" size="10">Conste por el presente documento, que entre los suscritos a saber <b> $nombreContratante .</b>$tipoDocumento .<b>$contratante</b> quien para efectos del presente se
				denominará CONTRATANTE, y el señor <b>TRANSCORVALLE S.A.S, </b>NIT. No <b>821.002.227-2</b>, quien para efectos del mismo se denominará CONTRATISTA,
				hemos celebrado el presente contrato de transporte, estipulado con las siguientes cláusulas:</font></p>

				<p align="justify"><font face="Arial" size="10"><b>PRIMERA: </b>El CONTRATISTA se compromete a facilitar un vehículo para transporte de pasajeros afiliado a <b>TRANSCORVALLE S.A.S., </b>
				en la siguiente forma:

				<br><br><b>ORIGEN:</b> $origen <b>DESTINO:</b> $destino

				<br><b>DIRECCION SALIDA</b>: $direccionSalida <b>HORA SALIDA:</b> $horaSalida <b>HORA REGRESO</b>:  $horaRegreso

				<br><b>FECHA DE SALIDA</b> $fechaSalida <b> FECHA DE REGRESO</b> $fechaRegreso

				<br><b>PLACA:</b> $placa <b>MARCA:</b> $marca  <b>MODELO:</b> $modelo

				<br><b>No PASAJEROS:</b> $numPasjeros <b>N° INTERNO</b> $numeroInterno

				<br><b>No. VEHICULOS CONTRATADOS:</b> $vehiContra <b>ABONO:</b>$$abono <b>SALDO:</b>$ $saldo</font></p>

				<p align="justify"><font face="Arial" size="10"><b>SEGUNDA</b>: El CONTRATISTA se compromete con el CONTRATANTE a realizar un viaje en plan de excursión a
				los siguientes sitios: <b>$destino </b>El CONTRATISTA entregará a la disponibilidad del CONTRATANTE los puestos del vehículo, sin sobrepasar el cupo permitido
				de su capacidad y el CONTRATANTE respetará el puesto auxiliar. <b>TERCERA</b>: El tiempo de duración del viaje es de <b>$duracion</b> días contados a partir del
				<b>$fechaSalida </b> hasta el día <b>$fechaRegreso </b>. <b>CUARTA</b>: EL CONTRATANTE se compromete a hacer una revisión antes de salir el vehículo y por lo tanto
				se hará responsable por daños en la cojinería, cortinas, vidrios y otros que dañen los excursionistas. <b>QUINTA</b>: El Valor acordado del viaje es de
				<b>$totalLetras pesos Mcte ($ $total). SEXTA</b> Como viaje de carácter turístico se prohíbe tanto al CONTRATANTE, motoristas,
				excursionistas el transporte de mercancías y objetos no permitidos por la Ley. <b>SEPTIMA</b>: El valor del viaje no variará si por algún motivo los
				excursionistas o contratantes no pudieran completar el cupo o pacten el regreso antes de lo previsto. <b>OCTAVA</b>: Si no se efectuará el servicio
				por causas del CONTRATANTE, el CONTRATISTA cobrará la suma del cincuenta (50%) por ciento del precio convenido por cada vehículo contratado.
				<b>NOVENA</b>: Si no se presenta a prestar el vehículo el transportador o CONTRATISTA salvo fuerza mayor comprobada y demostrada, el CONTRATANTE
				cobrará la suma del cincuenta (50%) por ciento del precio establecido. <b>DECIMA</b>: El CONTRATISTA da a disposición dicho vehículo con sus respectivas
				 pólizas de seguro dispuestas por Ley. <b>DECIMA PRIMERA</b>: Como medida de seguridad el conductor no debe llevar acompañantes (La familia).
				 <b>DECIMA SEGUNDA:</b> Se considera incorporadas en el presente contrato todas las disposiciones legales que tratan en el mismo. <b>DECIMA TERCERA:
				 </b>El vehículo lo recibe el CONTRATANTE, en perfecto estado de cojinería, vidrios y así lo debe entregar al terminar el Contrato.
				 <b>DECIMA CUARTA</b>: Forma de Pago, a la firma del Contrato el 50% y el saldo restante al salir el vehículo el día del viaje.
				 <b>NO SE ACEPTA SOBRECUPO</b>. <b>NOTA</b>. Según ley 769/2002 del código Nacional de Transito y Transporte, todo NIÑO MAYOR DE TRES (03) AÑOS OCUPA
				 UN PUESTO.</font></p>

				<p align="justify"><font face="Arial" size="10">Para constancia se firma en Tuluá, a los <b>$diaFirma ($diaFirmaString) </b>días del mes de <b>$mesFirma</b> del año
				<b>$yearString ($year)</b>.</font></p>

EOD;
		$this->pdf->writeHTML($html, true, false, true, false, '');

		$this->pdf->Image(K_PATH_IMAGES.'firmaContratista.png', 40,250,50,0, '', '', '', false, 0);
		$this->pdf->Image(K_PATH_IMAGES.'firmaContratante.png',120,250,50,0, '', '', '', false, 0);
	}

	function fuec($numerofuec)
	{

		$html = <<<EOD

		<br><br>
		<table width="100%">
			<tr>
				<td border="1" width="100%">
						<font style="font-size:12 font-weight: bold; text-align:center">
							FICHA TECNICA DEL FORMATO &#218;NICO DEL EXTRACTO DEL CONTRATO "FUEC"
						</font>
				</td>
			</tr>
			<tr>
				<td  border="1" width="50%" >
					<br>
					<div valign="middle" align="center">
						<img width="200" height="60" src="../Images/mintransporte.png"/>
					</div>
				</td>
				<td  border="1" width="50%">
					<br>
					<div valign="middle" align="center">
						<img width="200" height="60" src="../Images/Logo.png"/>
					</div>
				</td>
			</tr>
			<tr>
				<td  border="1" width="100%" valign="middle" align="center">
					<font style="font-size:10 font-weight:bold;" >
						<br>
						FORMATO UNICO DE EXTRACTO DEL CONTRATO DEL SERVICIO P&#218;BLICO DE TRANSPORTE TERRESTRE AUTOMOTOR
						ESPECIAL N.3760092002014
					</font>
				</td>
			</tr>
			<tr>
				<td  border="1" width="35%" align="center">
					<font style="font-size:10" >
						RAZ&#211;N SOCIAL:
					</font>
				</td>
				<td border="1" width="35%"  align="center">
					<font style="font-size:10" >
						TRANSCORVALLE S.A.S.
					</font>
				</td>
				<td border="1" width="10%"  align="center">
					<font style="font-size:10" >
						NIT
					</font>
				</td>
				<td border="1" width="20%"  align="center">
					<font style="font-size:10" >
						821.002.227-2
					</font>
				</td>
			</tr>
			<tr>
				<td border="1" width="35%" align="center">
					<font style="font-size:10" >
						CONTRATO N.
					</font>
				</td>
				<td border="1" width="65%" align="center">
					<font style="font-size:10" >
						&nbsp;
					</font>
				</td>
			</tr>
			<tr>
				<td border="1" width="35%" align="center">
					<font style="font-size:10" >
					CONTRATANTE:
					</font>
				</td>
				<td border="1" width="35%" align="center">
					<font style="font-size:10" >
						&nbsp;
					</font>
				</td>
				<td border="1" width="10%" align="center">
					<font style="font-size:10" >
						NIT
					</font>
				</td>
				<td border="1" width="20%" align="center">
					<font style="font-size:10" >
						&nbsp;
					</font>
				</td>
			</tr>
			<tr>
				<td border="1" width="100%" align="left">
					<font style="font-size:10" >
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						OBJETO DEL CONTRATO:
					</font>
				</td>
			</tr>
			<tr>
				<td border="1" width="100%" align="left">
					<font style="font-size:10" >
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						RECORRIDO:
					</font>
				</td>
			</tr>
<tr  >
<td   width="25%" nowrap="" colspan="1" valign="bottom">
<p>&nbsp;CONVENIO CONSORCIO UNION TEMPORAL CON:</p>
</td>
<td   width="75%" nowrap="" colspan="11" valign="bottom"></td>
</tr>
<tr  >
<td   width="100%" colspan="12" valign="bottom">
<p align="center"><strong>VIGENCIA DEL CONTRATO</strong></p>
</td>
</tr>
<tr>
<td   width="25%" colspan="1" nowrap="" valign="bottom">
<p>&nbsp;FECHA INICIAL:</p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p>&nbsp;DIA:</p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p>&nbsp;MES:</p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p>&nbsp;A&#209;O:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" nowrap=""  valign="bottom">
<p>&nbsp;FECHA VENCIMIENTO</p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p>&nbsp;DIA:</p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p>&nbsp;MES:</p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p>&nbsp;A&#209;O:</p>
</td>
</tr>
<tr  >
<td   width="100%" nowrap="" colspan="12" rowspan="1" valign="top">
<p align="center"><strong>CARACTERISTICAS DEL VEH&#205;CULO</strong></p>
</td>
</tr>
<tr   >
<td   width="25%" colspan="1" nowrap=""  valign="bottom">
<p align="center"><strong>&nbsp;PLACA</strong></p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p align="center"><strong>&nbsp;MODELO</strong></p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p align="center"><strong>&nbsp;MARCA</strong></p>
</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">
<p align="center"><strong>&nbsp;CLASE</strong></p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" nowrap=""  valign="bottom">&nbsp;</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">&nbsp;</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">&nbsp;</td>
<td   width="25%" colspan="4" nowrap=""  valign="bottom">&nbsp;</td>
</tr>
<tr  >
<td   width="50%" nowrap="" colspan="4" valign="bottom">
<p align="center"><strong>NUMERO INTERNO</strong></p>
</td>
<td   width="50%" nowrap="" colspan="8" valign="bottom">
<p align="center"><strong>NUMERO DE TARJETA DE OPERACI&#211;N</strong></p>
</td>
</tr>
<tr  >
<td   width="50%" colspan="4" nowrap=""  valign="bottom">&nbsp;</td>
<td   width="50%" colspan="8" nowrap=""  valign="bottom">&nbsp;</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;CONDUCTOR 1:</p>
</td>
<td   width="25%" nowrap="" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;N. Licencia Conducci&#243;n:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;Vigencia:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;CONDUCTOR 2:</p>
</td>
<td   width="25%" nowrap="" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;N. Licencia Conducci&#243;n:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;Vigencia:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;RESPONSABLE DEL CONTRATANTE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;TELEFONO:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;DIRECCI&#211;N:</p>
</td>
</tr>
<tr  >
<td   width="100%" nowrap="" colspan="12" valign="bottom">
<p align="center"><strong>OCUPANTES GRUPO ESPECIFICO DE USUARIOS.</strong></p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="25%" colspan="1" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;NOMBRE:</p>
</td>
<td   width="25%" colspan="4" rowspan="1" valign="top">
<p>&nbsp;C.C.:</p>
</td>
</tr>
<tr  >
<td   width="50%" nowrap="" colspan="4" rowspan="1" valign="top">
<p align='center'><strong><em><br>&nbsp;Calle 27 # 32-47 Tulu&#225;, Valle
<br>&nbsp;Tel: (57 2) 225 3308
<br>&nbsp;Cel.: (57) 310-420 1819
<br>&nbsp;Transcorvalle@hotmail.es
</em>
</strong>
</p>
</td>
<td   width="50%" nowrap="" colspan="8" rowspan="1" valign="bottom">
<p align="center">FIRMA Y SELLO</p>
</td>
</tr>
	</table>
EOD;
		$this->pdf->writeHTML($html, true, false, true, false, '');
	}
}
?>
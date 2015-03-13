<?php

class Fuec
{
	var $util;
	var $result;

	function Fuec()
	{
		$this->util = new Utilities();
	}

	function addFuec($fuecData)
	{
		$respCode = 0;
		$fuecGeneralData = $fuecData->fuecFormGeneralData->fuecFormGeneral;
		$fuecResponsibleData = $fuecData->fuecFormResponsibleData->fuecFormResponsible;
		$fuecDriver1Data = $fuecData->fuecFormDriver1Data->fuecFormDriver1;
		$fuecDriver2Data = $fuecData->fuecFormDriver2Data->fuecFormDriver2;

		$this->result = $this->util->db->Execute("SELECT cc_placa_fld AS plate FROM cc_contract_tbl WHERE cc_id_fld = " . $fuecGeneralData->contractNumber);
		$result = $this->result->FetchRow();
		$separators = array(' ','-');
		$plate = strtoupper(str_replace($separators, '', $fuecGeneralData->plate));
		if($result) {
			if(strpos($result['plate'], $plate) === false) {
				$respCode = 2;
			}
		}
		else {
			$respCode = 1;
		}
		if($respCode == 0) {
			$this->result = $this->util->db->Execute("SELECT * FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '" . $fuecDriver1Data->docTypeDriver1 . "' AND
																						  cc_nume_doc_fld = '" . $fuecDriver1Data->docNumDriver1 . "' AND
																						  cc_type_pc_fld in ('01','02')");
			$result = $this->result->FetchRow();
			if($result) {
				if($fuecDriver2Data->docTypeDriver2 != '' && $fuecDriver2Data->docTypeDriver2 != '') {
					$this->result = $this->util->db->Execute("SELECT * FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '" . $fuecDriver2Data->docTypeDriver2 . "' AND
																								  cc_nume_doc_fld = '" . $fuecDriver2Data->docNumDriver2 . "' AND
																								  cc_type_pc_fld in ('01','02')");
					$result = $this->result->FetchRow();
					if(!$result) {
						$respCode = 4;
					}
				}
			}
			else {
				$respCode = 3;
			}
		}
		if($respCode == 0) {
			$this->getNextConsecutive();
			$result = $this->result->FetchRow();
			$numFuec = '376009200' . date('Y') . str_pad($fuecGeneralData->contractNumber, 4, "0", STR_PAD_LEFT) . $result['number'];

			$this->result = $this->util->db->Execute("INSERT INTO cc_fuec_tbl VALUES (0, '" . $numFuec . "',
																						  " . $fuecGeneralData->contractNumber . ",
																						 '" . $plate . "',
																						 '" . $fuecGeneralData->agreement . "',
																						 '" . $fuecResponsibleData->docTypeResponsible . "',
																						 '" . $fuecResponsibleData->docNumResponsible . "',
																						 '" . $fuecResponsibleData->nameResponsible . "',
																						 '" . $fuecResponsibleData->phoneResponsible . "',
																						 '" . $fuecResponsibleData->addressResponsible . "',
																						 '" . $fuecDriver1Data->docTypeDriver1 . "',
																						 '" . $fuecDriver2Data->docNumDriver2 . "',
																						 '" . $fuecDriver2Data->docTypeDriver2 . "',
																						 '" . $fuecDriver1Data->docNumDriver1 . "')");
			/*if(!$this->result) {
				$this->util->db->Execute("DELETE FROM cc_fuec_tbl WHERE cc_numero_fuec_fld = ".$numFuec);
				$respCode = 99;
			}
			else {*/
				$_SESSION['number'] = $numFuec;
			//}
		}
		return $respCode;
	}

	function addFuecPassenger($fuecPassengerData, $numFuec)	{
		$respCode = 0;
		$fuecBasicData = $fuecPassengerData->fuecFormBasicData->fuecFormBasic;
		if(is_array($fuecBasicData)) {
			foreach($fuecBasicData as $fuec) {
				if($fuec->docNum != '') {
					$this->getNextConsecutivePassenger($numFuec);
					$result = $this->result->FetchRow();
					$this->result = $this->util->db->Execute("INSERT INTO cc_fuec_ocupantes_tbl VALUES (0, " . ($result['number'] + 1)	 . ", '" . $numFuec . "', '" . $fuec->docType . "', '" . $fuec->docNum . "', '" . $fuec->name . "')");
					if(!$this->result) {
						$this->util->db->Execute("DELETE FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '".$numFuec."'");
						$respCode = 99;
						break;
					}
				}
			}
		}
		else {
			if($fuecBasicData->docNum != '') {
				$this->getNextConsecutivePassenger($numFuec);
				$result = $this->result->FetchRow();
				$this->result = $this->util->db->Execute("INSERT INTO cc_fuec_ocupantes_tbl VALUES (0, " . ($result['number'] + 1) . ", '" . $numFuec . "', '" . $fuecBasicData->docType . "', '" . $fuecBasicData->docNum . "', '" . $fuecBasicData->name . "')");
				if(!$this->result) {
					$this->util->db->Execute("DELETE FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '".$numFuec."'");
					$respCode = 99;
					break;
				}
			}
		}
		return $respCode;
	}

	function getNextConsecutive() {
		$this->result = $this->util->db->Execute("SHOW TABLE STATUS LIKE 'cc_fuec_tbl'");
		$result = $this->result->FetchRow();
		$this->result = $this->util->db->Execute("SELECT LPAD(".$result['Auto_increment'].", 4, 0) AS number FROM DUAL");
	}

	function getNextConsecutivePassenger($number) {
		$this->result = $this->util->db->Execute("SELECT IFNULL(MAX(cc_id_ocupante_fld), 0) AS number FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '" . $number . "'");
	}

	function getPassengersFuec($number) {
		$this->result = $this->util->db->Execute("SELECT cc_tipo_doc_fld AS docType,
														 cc_num_id_fld AS docNum,
														 cc_nombre_fld AS name
												  FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '" . $number . "' ORDER BY cc_id_fld");
	}

	function getPassengerFuec($number, $numberId) {
		$this->result = $this->util->db->Execute("SELECT cc_tipo_doc_fld AS docType,
														 cc_num_id_fld AS docNum,
														 cc_nombre_fld AS name
												  FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '" . $number . "' AND cc_id_ocupante_fld = '" . $numberId . "'");
	}

	function getPassengerFuecView($number, $numberId) {
		$this->result = $this->util->db->Execute("SELECT cc_tipo_doc_fld AS docType,
														 cc_num_id_fld AS docNum,
														 cc_nombre_fld AS name
												  FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '" . $number . "' AND cc_num_id_fld = '" . $numberId . "'");
	}

	function getCapacityAvailable($numFuec) {
		$this->result = $this->util->db->Execute("SELECT (V.cc_capacidad_fld - (SELECT COUNT(*) FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '" . $numFuec . "')) AS size
							FROM cc_fuec_tbl F INNER JOIN cc_vehicle_tbl V ON F.cc_placa_fld = V.cc_placa_fld WHERE F.cc_numero_fuec_fld = '" . $numFuec . "'");
	}

	function modifyFuecPassenger($fuecPassengerData, $numFuec, $numberId) {
		$respCode = 0;
		$fuecModifyData = $fuecPassengerData->fuecFormModifyData->fuecFormModify;
		if($fuecModifyData->docNum != '') {
			$this->result = $this->util->db->Execute("UPDATE cc_fuec_ocupantes_tbl SET
															 cc_tipo_doc_fld = '" . $fuecModifyData->docType . "',
															 cc_num_id_fld = '" . $fuecModifyData->docNum . "',
															 cc_nombre_fld = '" . $fuecModifyData->name . "'
													  WHERE cc_numero_fuec_fld = '".$numFuec."' AND cc_num_id_fld = '" . $numberId . "'");
		}
		else {
			$this->util->db->Execute("DELETE FROM cc_fuec_ocupantes_tbl WHERE cc_numero_fuec_fld = '".$numFuec."' AND cc_num_id_fld = '" . $numberId . "'");
			$this->getPassengersFuec($numFuec);
			$nextPassenger = 1;
			while($result = $this->result->FetchRow()) {
				$this->util->db->Execute("UPDATE cc_fuec_ocupantes_tbl SET cc_id_ocupante_fld = " . $nextPassenger . " WHERE cc_numero_fuec_fld = '".$numFuec."' AND cc_num_id_fld = '" . $result['docNum'] . "'");
				$nextPassenger ++;
			}
		}
		return $respcode;
	}

	function getFuec($numeroFuec) {
		$this->result = $this->util->db->Execute("SELECT	a.cc_num_contrato_tbl, (select c.cc_fnombre_fld from cc_person_tbl c where c.cc_nume_doc_fld =b.cc_nume_doc_fld), b.cc_nume_doc_fld, b.cc_objetocont_fld,
															concat('de ',b.cc_origen_fld,' a ',b.cc_destino_fld),a.cc_convenio_fld,
															extract(day from b.cc_fechasali_fld),extract(month from b.cc_fechasali_fld),extract(year from b.cc_fechasali_fld),
															extract(day from b.cc_fecharegr_fld),extract(month from b.cc_fecharegr_fld),extract(year from b.cc_fecharegr_fld),
															a.cc_placa_fld,d.cc_modelo_fld,
															(select x.cc_descripcion_fld from cc_valores_tbl x where x.cc_campo_fld = 'cc_marca_fld' and x.cc_valor_fld = d.cc_marca_fld),
															(select x.cc_descripcion_fld from cc_valores_tbl x where x.cc_campo_fld = 'cc_clase_fld' and x.cc_valor_fld = d.cc_clase_fld),
															d.cc_codigointerno_fld,
															(select x.cc_identificador_fld from cc_documento_tbl x where x.cc_placa_fld = a.cc_placa_fld and x.cc_tipo_docum_fld='01' ),
														   (select x.cc_fnombre_fld from cc_person_tbl x where x.cc_tipo_doc_fld = a.cc_tipo_doc_conductor1_fld and x.cc_nume_doc_fld=a.cc_num_doc_conductor1_fld)
															,a.cc_num_doc_conductor1_fld
															,(select x.cc_numlicencia_fld from cc_propcond_tbl x where x.cc_tipo_doc_fld = a.cc_tipo_doc_conductor1_fld and x.cc_nume_doc_fld=a.cc_num_doc_conductor1_fld)
															,(select date_format(x.cc_fchvenclicencia_fld,'%d/%m/%y') from cc_propcond_tbl x where x.cc_tipo_doc_fld = a.cc_tipo_doc_conductor1_fld and x.cc_nume_doc_fld=a.cc_num_doc_conductor1_fld)
															,(select x.cc_fnombre_fld from cc_person_tbl x where x.cc_tipo_doc_fld = a.cc_tipo_doc_conductor2_fld and x.cc_nume_doc_fld=a.cc_num_doc_coductor2_fld)
															, a.cc_num_doc_coductor2_fld
															,(select x.cc_numlicencia_fld from cc_propcond_tbl x where x.cc_tipo_doc_fld = a.cc_tipo_doc_conductor2_fld and x.cc_nume_doc_fld=a.cc_num_doc_coductor2_fld)
															,(select date_format(x.cc_fchvenclicencia_fld,'%d/%m/%y') from cc_propcond_tbl x where x.cc_tipo_doc_fld = a.cc_tipo_doc_conductor2_fld and x.cc_nume_doc_fld=a.cc_num_doc_coductor2_fld)
												  			,a.cc_nombre_responsable_fld
															,a.cc_num_doc_responsable_fld
															,a.cc_tel_responsable_fld
        													,a.cc_dir_responsable_fld
        													,b.cc_origen_fld
        													,b.cc_destino_fld
        													,concat(b.cc_fechasali_fld ,' ',b.cc_horasali_fld)
        													,concat(b.cc_fecharegr_fld ,' ',b.cc_horaregr_fld)
        										  from    	cc_fuec_tbl a, cc_contract_tbl b , cc_vehicle_tbl d
												  where		a.cc_num_contrato_tbl = b.cc_id_fld
												  and     	a.cc_placa_fld = d.cc_placa_fld
												  and		a.cc_numero_fuec_fld = '".$numeroFuec."'");
	}
 }
?>
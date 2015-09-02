<?php

class Vehicle
{
	var $util;
	var $result;

	function Vehicle()
	{
		$this->util = new Utilities();
	}

	function addVehicle($vehicleData)
	{
		$respCode = 0;
		$vehicleBasicData = $vehicleData->vehicleFormBasicData->vehicleFormBasic;
		$vehicleFeatureData = $vehicleData->vehicleFormFeatureData->vehicleFormFeature;
		$vehicleOwnerData = $vehicleData->vehicleFormOwnerData->vehicleFormOwner;
		$vehicleDriverData = $vehicleData->vehicleFormDriverData->vehicleFormDriver;
		$vehicleComments = $vehicleData->vehicleFormCommentsData->vehicleFormComments;
		$this->result = $this->util->db->Execute("SELECT * FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '".$vehicleOwnerData->docTypeOwner."' AND
																					  cc_nume_doc_fld = '".$vehicleOwnerData->numDocOwner."' AND
																					  cc_type_pc_fld in ('01','02')");
		if($this->result->FetchRow()) {
			$this->result = $this->util->db->Execute("INSERT INTO cc_vehicle_tbl VALUES('".$vehicleBasicData->plate."',
																						'".$vehicleBasicData->internalCode."',
																						'".$vehicleBasicData->trademark."',
																						'".$vehicleBasicData->model."',
																						'".$vehicleBasicData->class."',
																						'".$vehicleFeatureData->type."',
																						'".$vehicleFeatureData->size."',
																						'".$vehicleFeatureData->numMachine."',
																						'".$vehicleFeatureData->numChassis."',
																						'".$vehicleFeatureData->cylinderCapcity."',
																						'".$vehicleBasicData->color."',
																						'".$vehicleComments->details."')");
			if($this->result) {
				$this->result = $this->util->db->Execute("INSERT INTO cc_per_veh_tbl VALUES('".$vehicleOwnerData->docTypeOwner."',
																							'".$vehicleOwnerData->numDocOwner."',
																							'".$vehicleBasicData->plate."')");
				if($this->result) {
					if($vehicleDriverData->numDocDriver != '' && $vehicleDriverData->docTypeDriver != '') {
						if($vehicleOwnerData->numDocOwner != $vehicleDriverData->numDocDriver) {
							$this->result = $this->util->db->Execute("SELECT * FROM cc_propcond_tbl WHERE cc_tipo_doc_fld = '".$vehicleDriverData->docTypeDriver."' AND
																										  cc_nume_doc_fld = '".$vehicleDriverData->numDocDriver."' AND
																										  cc_type_pc_fld in ('01','02')");
							if($this->result->FetchRow()) {
								$this->result = $this->util->db->Execute("INSERT INTO cc_per_veh_tbl VALUES('".$vehicleDriverData->docTypeDriver."',
																											'".$vehicleDriverData->numDocDriver."',
																											'".$vehicleBasicData->plate."')");
							}
							else {
								$this->util->db->Execute("DELETE FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$vehicleBasicData->plate."'");
								$this->util->db->Execute("DELETE FROM cc_per_veh_tbl WHERE cc_placa_fld = '".$vehicleBasicData->plate."'");
								$respCode = 3;
							}
						}
					}
				}
				else {
					$this->util->db->Execute("DELETE FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$vehicleBasicData->plate."'");
					$this->util->db->Execute("DELETE FROM cc_per_veh_tbl WHERE cc_placa_fld = '".$vehicleBasicData->plate."'");
					$respCode = 1;
				}
			}
			else {
				$this->util->db->Execute("DELETE FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$vehicleBasicData->plate."'");
				$respCode = 1;
			}
		}
		else {
			$respCode = 2;
		}
		return $respCode;
	}

	function getVehicle($plate) {
		$this->result = $this->util->db->Execute("SELECT V.cc_placa_fld AS plate,
														 V.cc_codigointerno_fld AS internalCode,
														 V.cc_marca_fld AS trademark,
														 V.cc_modelo_fld AS model,
														 V.cc_clase_fld AS class,
														 V.cc_tipo_fld AS type,
														 V.cc_capacidad_fld AS size,
														 V.cc_num_motor_fld AS numMachine,
														 V.cc_num_chasis_fld AS numChassis,
														 V.cc_lin_cilindr_fld AS cylinderCapcity,
														 V.cc_color_fld AS color,
														 V.cc_detalles_fld AS details,
														 (SELECT PV.cc_tipo_doc_fld FROM cc_per_veh_tbl PV INNER JOIN cc_propcond_tbl PC ON PV.cc_tipo_doc_fld = PC.cc_tipo_doc_fld AND PV.cc_nume_doc_fld = PC.cc_nume_doc_fld WHERE PV.cc_placa_fld = '".$plate."' AND PC.cc_type_pc_fld = '01') AS docTypeOwner,
														 (SELECT PV.cc_nume_doc_fld FROM cc_per_veh_tbl PV INNER JOIN cc_propcond_tbl PC ON PV.cc_tipo_doc_fld = PC.cc_tipo_doc_fld AND PV.cc_nume_doc_fld = PC.cc_nume_doc_fld WHERE PV.cc_placa_fld = '".$plate."' AND PC.cc_type_pc_fld = '01') AS numDocOwner,
														 (SELECT PV.cc_tipo_doc_fld FROM cc_per_veh_tbl PV INNER JOIN cc_propcond_tbl PC ON PV.cc_tipo_doc_fld = PC.cc_tipo_doc_fld AND PV.cc_nume_doc_fld = PC.cc_nume_doc_fld WHERE PV.cc_placa_fld = '".$plate."' AND PC.cc_type_pc_fld = '02') AS docTypeDriver,
														 (SELECT PV.cc_nume_doc_fld FROM cc_per_veh_tbl PV INNER JOIN cc_propcond_tbl PC ON PV.cc_tipo_doc_fld = PC.cc_tipo_doc_fld AND PV.cc_nume_doc_fld = PC.cc_nume_doc_fld WHERE PV.cc_placa_fld = '".$plate."' AND PC.cc_type_pc_fld = '02') AS numDocDriver
												  FROM cc_vehicle_tbl V
												  WHERE V.cc_placa_fld = '".$plate."'");
	}

	function modifyVehicle($vehicleData, $plate) {
		$respCode = 0;
		$vehicleBasicData = $vehicleData->vehicleFormBasicData->vehicleFormBasic;
		$this->util->db->Execute("DELETE FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$plate."'");
		$this->util->db->Execute("DELETE FROM cc_per_veh_tbl WHERE cc_placa_fld = '".$plate."'");
		$respCode = $this->addVehicle($vehicleData);
		return $respCode;
	}
 }
?>
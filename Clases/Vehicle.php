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
		$this->result = $this->util->db->Execute("SELECT * FROM CC_PROPCOND_TBL WHERE CC_TIPO_DOC_FLD = '".$vehicleOwnerData->docTypeOwner."' AND 
																					  CC_NUME_DOC_FLD = '".$vehicleOwnerData->numDocOwner."' AND 
																					  CC_TYPE_PC_FLD = '01'");
		if($this->result->FetchRow()) {
			$this->result = $this->util->db->Execute("INSERT INTO CC_VEHICLE_TBL VALUES('".$vehicleBasicData->plate."',
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
				$this->result = $this->util->db->Execute("INSERT INTO CC_PER_VEH_TBL VALUES('".$vehicleOwnerData->docTypeOwner."',
																							'".$vehicleOwnerData->numDocOwner."',
																							'".$vehicleBasicData->plate."')");
				if($this->result) {
					if($vehicleDriverData->numDocDriver != '' && $vehicleDriverData->docTypeDriver != '') {
						if($vehicleOwnerData->numDocOwner != $vehicleDriverData->numDocDriver) {
							$this->result = $this->util->db->Execute("SELECT * FROM CC_PROPCOND_TBL WHERE CC_TIPO_DOC_FLD = '".$vehicleDriverData->docTypeDriver."' AND 
																										  CC_NUME_DOC_FLD = '".$vehicleDriverData->numDocDriver."' AND 
																										  CC_TYPE_PC_FLD in ('01','02')");
							if($this->result->FetchRow()) {
								$this->result = $this->util->db->Execute("INSERT INTO CC_PER_VEH_TBL VALUES('".$vehicleDriverData->docTypeDriver."',
																											'".$vehicleDriverData->numDocDriver."',
																											'".$vehicleBasicData->plate."')");
							}
							else {
								$this->util->db->Execute("DELETE FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$vehicleBasicData->plate."'");
								$this->util->db->Execute("DELETE FROM CC_PER_VEH_TBL WHERE CC_PLACA_FLD = '".$vehicleBasicData->plate."'");
								$respCode = 3;
							}
						}
					}
				}
				else {
					$this->util->db->Execute("DELETE FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$vehicleBasicData->plate."'");
					$this->util->db->Execute("DELETE FROM CC_PER_VEH_TBL WHERE CC_PLACA_FLD = '".$vehicleBasicData->plate."'");
					$respCode = 1;
				}
			}
			else {
				$this->util->db->Execute("DELETE FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$vehicleBasicData->plate."'");								   
				$respCode = 1;
			}
		}
		else {
			$respCode = 2;
		}
		return $respCode;
	}
	
	function getVehicle($plate) {
		$this->result = $this->util->db->Execute("SELECT V.CC_PLACA_FLD AS plate,
														 V.CC_CODIGOINTERNO_FLD AS internalCode,
														 V.CC_MARCA_FLD AS trademark,
														 V.CC_MODELO_FLD AS model,
														 V.CC_CLASE_FLD AS class,
														 V.CC_TIPO_FLD AS type,
														 V.CC_CAPACIDAD_FLD AS size,
														 V.CC_NUM_MOTOR_FLD AS numMachine,
														 V.CC_NUM_CHASIS_FLD AS numChassis,
														 V.CC_LIN_CILINDR_FLD AS cylinderCapcity,
														 V.CC_COLOR_FLD AS color,
														 V.CC_DETALLES_FLD AS details,
														 (SELECT PV.CC_TIPO_DOC_FLD FROM CC_PER_VEH_TBL PV INNER JOIN CC_PROPCOND_TBL PC ON PV.CC_TIPO_DOC_FLD = PC.CC_TIPO_DOC_FLD AND PV.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE PV.CC_PLACA_FLD = '".$plate."' AND PC.CC_TYPE_PC_FLD = '01') AS docTypeOwner,
														 (SELECT PV.CC_NUME_DOC_FLD FROM CC_PER_VEH_TBL PV INNER JOIN CC_PROPCOND_TBL PC ON PV.CC_TIPO_DOC_FLD = PC.CC_TIPO_DOC_FLD AND PV.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE PV.CC_PLACA_FLD = '".$plate."' AND PC.CC_TYPE_PC_FLD = '01') AS numDocOwner,
														 (SELECT PV.CC_TIPO_DOC_FLD FROM CC_PER_VEH_TBL PV INNER JOIN CC_PROPCOND_TBL PC ON PV.CC_TIPO_DOC_FLD = PC.CC_TIPO_DOC_FLD AND PV.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE PV.CC_PLACA_FLD = '".$plate."' AND PC.CC_TYPE_PC_FLD = '02') AS docTypeDriver,
														 (SELECT PV.CC_NUME_DOC_FLD FROM CC_PER_VEH_TBL PV INNER JOIN CC_PROPCOND_TBL PC ON PV.CC_TIPO_DOC_FLD = PC.CC_TIPO_DOC_FLD AND PV.CC_NUME_DOC_FLD = PC.CC_NUME_DOC_FLD WHERE PV.CC_PLACA_FLD = '".$plate."' AND PC.CC_TYPE_PC_FLD = '02') AS numDocDriver
												  FROM CC_VEHICLE_TBL V
												  WHERE V.CC_PLACA_FLD = '".$plate."'");
	}
	
	function modifyVehicle($vehicleData, $plate) {
		$respCode = 0;		
		$vehicleBasicData = $vehicleData->vehicleFormBasicData->vehicleFormBasic;
		$this->util->db->Execute("DELETE FROM CC_VEHICLE_TBL WHERE CC_PLACA_FLD = '".$plate."'");
		$this->util->db->Execute("DELETE FROM CC_PER_VEH_TBL WHERE CC_PLACA_FLD = '".$plate."'");
		$respCode = $this->addVehicle($vehicleData);
		return $respCode;
	}
 }
?>
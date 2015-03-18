<?php

class Maintenance
{
	var $util;
	var $result;

	function Maintenance()
	{
		$this->util = new Utilities();
	}

	function addMaintenance($maintenanceData) {
		$respCode = 0;
		$maintenanceBasicData = $maintenanceData->maintenanceFormBasicData->maintenanceFormBasic;
		$maintenanceComments = $maintenanceData->maintenanceFormCommentsData->maintenanceFormComments;
        
        $fechaMantenimiento = strtotime($maintenanceBasicData->maintenanceDate->year.'/'.$maintenanceBasicData->maintenanceDate->month.'/'.$maintenanceBasicData->maintenanceDate->day);
        $fechaProximoMantenimiento = strtotime($maintenanceBasicData->nextMaintenanceDate->year.'/'.$maintenanceBasicData->nextMaintenanceDate->month.'/'.$maintenanceBasicData->nextMaintenanceDate->day);
        $fecha_actual = localtime(time(), 1);
		$anyo_actual  = $fecha_actual["tm_year"] + 1900;
		$mes_actual   = $fecha_actual["tm_mon"] + 1;
		$dia_actual   = $fecha_actual["tm_mday"];
        if($fechaMantenimiento < $fechaProximoMantenimiento) {
            //if($fechaMantenimiento <= strtotime($anyo_actual.'/'.$mes_actual.'/'.$dia_actual)) {///pendiente
                $separators = array(' ','-');
                $plate = strtoupper(str_replace($separators, '', $maintenanceBasicData->plate));
                if(strlen($plate) == 6) {
                    $this->result = $this->util->db->Execute("SELECT * FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$plate."'");
                    if($this->result->FetchRow()) {
						$this->result = $this->util->db->Execute("SELECT cc_id_fld AS ID FROM cc_mantenimientos_tbl
																  WHERE cc_tipo_fld = '".$maintenanceBasicData->maintenanceType."' AND
																	    cc_placa_fld = '".$maintenanceBasicData->plate."' AND 
																		cc_estado_fld = 'A'");
						$result = $this->result->FetchRow();
						if($result != null) {
							$this->result = $this->util->db->Execute("UPDATE cc_mantenimientos_tbl SET cc_estado_fld = 'I'
																	  WHERE cc_id_fld = " . $result['ID']);
						}
                        $this->result = $this->util->db->Execute("INSERT INTO cc_mantenimientos_tbl VALUES(0,
                                                                                                      '".$maintenanceBasicData->maintenanceType."',
                                                                                                      '".$maintenanceBasicData->plate."',
                                                                                                      STR_TO_DATE('".$maintenanceBasicData->maintenanceDate->month."/".$maintenanceBasicData->maintenanceDate->day."/".$maintenanceBasicData->maintenanceDate->year."','%m/%d/%Y'),
                                                                                                      STR_TO_DATE('".$maintenanceBasicData->nextMaintenanceDate->month."/".$maintenanceBasicData->nextMaintenanceDate->day."/".$maintenanceBasicData->nextMaintenanceDate->year."','%m/%d/%Y'),
                                                                                                      '".$maintenanceBasicData->mileage."',
                                                                                                      '".$maintenanceBasicData->responsable."',
                                                                                                      '".$maintenanceBasicData->place."',
                                                                                                      '".$maintenanceComments->details."',
																									  'A')");
                        if(!$this->result) {
                            $this->util->db->Execute("DELETE FROM cc_mantenimientos_tbl WHERE cc_tipo_fld = '".$maintenanceBasicData->plate."' AND
                                                                                              cc_placa_fld = '".$maintenanceBasicData->number."' AND
                                                                                              cc_fecha_fld = STR_TO_DATE('".$maintenanceBasicData->maintenanceDate->month."/".$maintenanceBasicData->maintenanceDate->day."/".$maintenanceBasicData->maintenanceDate->year."','%m/%d/%Y')");
							$this->result = $this->util->db->Execute("UPDATE cc_mantenimientos_tbl SET cc_estado_fld = 'A'
																	  WHERE cc_id_fld = " . $result['ID']);
                            $respCode = 1;
                        }
                    }
                    else {
                        $respCode = 2;
                    }
                }
                else {
                       $respCode = 2; 
                }                
            /*}
            else {
                $respCode = 3;
            }*/
        }
        else {
              $respCode = 4;  
        }
		return $respCode;
	}

	function getMaintenance($ID) {
		$this->result = $this->util->db->Execute("SELECT cc_tipo_fld AS maintenanceType,
														 cc_placa_fld AS plate,
														 DATE_FORMAT(cc_fecha_fld, '%m/%d/%Y') AS maintenanceDate,
														 DATE_FORMAT(cc_proximo_fld, '%m/%d/%Y') AS nextMaintenanceDate,
														 cc_kilometraje_fld AS mileage,
														 cc_responsable_fld AS responsible,
														 cc_lugar_fld AS place,
														 cc_observaciones_fld AS details
												  FROM   cc_mantenimientos_tbl
												  WHERE  cc_id_fld = " . $ID);
	}

	function modifyMaintenance($maintenanceData, $ID) {
		$respCode = 0;
		$maintenanceBasicData = $maintenanceData->maintenanceFormBasicData->maintenanceFormBasic;
		$maintenanceComments = $maintenanceData->maintenanceFormCommentsData->maintenanceFormComments;
        
        $fechaMantenimiento = strtotime($maintenanceBasicData->maintenanceDate->year.'/'.$maintenanceBasicData->maintenanceDate->month.'/'.$maintenanceBasicData->maintenanceDate->day);
        $fechaProximoMantenimiento = strtotime($maintenanceBasicData->nextMaintenanceDate->year.'/'.$maintenanceBasicData->nextMaintenanceDate->month.'/'.$maintenanceBasicData->nextMaintenanceDate->day);
        $fecha_actual = localtime(time(), 1);
		$anyo_actual  = $fecha_actual["tm_year"] + 1900;
		$mes_actual   = $fecha_actual["tm_mon"] + 1;
		$dia_actual   = $fecha_actual["tm_mday"];
        if($fechaMantenimiento < $fechaProximoMantenimiento) {
            //if($fechaMantenimiento <= strtotime($anyo_actual.'/'.$mes_actual.'/'.$dia_actual)) {///pendiente
			$separators = array(' ','-');
                $plate = strtoupper(str_replace($separators, '', $maintenanceBasicData->plate));
                if(strlen($plate) == 6) {
                    $this->result = $this->util->db->Execute("SELECT * FROM cc_vehicle_tbl WHERE cc_placa_fld = '".$plate."'");
                    if($this->result->FetchRow()) {
                        $this->result = $this->util->db->Execute("UPDATE cc_mantenimientos_tbl SET cc_tipo_fld = '".$maintenanceBasicData->maintenanceType."',
																								 cc_placa_fld ='".$maintenanceBasicData->plate."',
																								 cc_fecha_fld = STR_TO_DATE('".$maintenanceBasicData->maintenanceDate->month."/".$maintenanceBasicData->maintenanceDate->day."/".$maintenanceBasicData->maintenanceDate->year."','%m/%d/%Y'),
																								 cc_proximo_fld = STR_TO_DATE('".$maintenanceBasicData->nextMaintenanceDate->month."/".$maintenanceBasicData->nextMaintenanceDate->day."/".$maintenanceBasicData->nextMaintenanceDate->year."','%m/%d/%Y'),
																								 cc_kilometraje_fld = '".$maintenanceBasicData->mileage."',
																								 cc_responsable_fld = '".$maintenanceBasicData->responsable."',
																								 cc_lugar_fld = '".$maintenanceBasicData->place."',
																								 cc_observaciones_fld = '".$maintenanceComments->details."',
																								 cc_estado_fld = 'A'
																			  WHERE cc_id_fld = " . $ID);
                    }
                    else {
                        $respCode = 2;
                    }
                }
                else {
                       $respCode = 2; 
                }                
            /*}
            else {
                $respCode = 3;
            }*/
        }
        else {
              $respCode = 4;  
        }
		return $respCode;
	}
 }
?>
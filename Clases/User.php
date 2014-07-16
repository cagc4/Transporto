<?php

class User
{
	var $util;
	var $result;
	
	function User()
	{
		$this->util = new Utilities();
	}

	function addUser($userData)
	{
		$respCode = 0;			
		$userBasicData = $userData->userFormBasicData->userFormBasic;
		$this->result = $this->util->db->Execute("INSERT INTO CC_USER_TBL VALUES('".$userBasicData->user."',
																				 '".$userBasicData->user."',
																				 '".$userBasicData->role."',
																				 'C')");
		if(!$this->result) {
			$this->util->db->Execute("DELETE FROM CC_USER_TBL WHERE CC_USER_ID_FLD = '".$userBasicData->user."'");								   
			$respCode = 1;
		}
		return $respCode;
	}
	
	function getUser($user) {
		$this->result = $this->util->db->Execute("SELECT CC_PSSWRD_FLD AS password,
														 CC_USER_ID_FLD AS user,
														 CC_ROLE_FLD AS role,
														 CC_ESTADO_FLD AS state
												  FROM CC_USER_TBL
												  WHERE CC_USER_ID_FLD = '".$user."'");
	}
	
	function modifyUser($userData) {
		$respCode = 0;			
		$userBasicData = $userData->userFormBasicData->userFormBasic;
		if($userBasicData->state == 'C') {
			$this->result = $this->util->db->Execute("UPDATE CC_USER_TBL SET CC_PSSWRD_FLD = '".$userBasicData->user."',
																			 CC_ROLE_FLD = '".$userBasicData->role."',
																			 CC_ESTADO_FLD = '".$userBasicData->state."'
													  WHERE CC_USER_ID_FLD = '".$userBasicData->user."'");
			if(!$this->result) {
				$respCode = 1;
			}
		}
		else {
			$this->result = $this->util->db->Execute("UPDATE CC_USER_TBL SET CC_ROLE_FLD = '".$userBasicData->role."',
																			 CC_ESTADO_FLD = '".$userBasicData->state."'
													  WHERE CC_USER_ID_FLD = '".$userBasicData->user."'");
			if(!$this->result) {
				$respCode = 1;
			}
		}
		return $respCode;
	}
	
	function modifyUserPass($userData) {
		$respCode = 0;			
		$userBasicData = $userData->loginFormBasicData->loginFormBasic;
		$this->result = $this->util->db->Execute("UPDATE CC_USER_TBL SET CC_PSSWRD_FLD = '".$userBasicData->password."',
																		 CC_ESTADO_FLD = 'A'
												  WHERE CC_USER_ID_FLD = '".$userBasicData->user."'");
		if(!$this->result) {
			$respCode = 1;
		}
		return $respCode;
	}
 }
?>
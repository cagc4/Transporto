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
		$this->result = $this->util->db->Execute("INSERT INTO cc_user_tbl VALUES('".$userBasicData->user."',
																				 '".md5($userBasicData->user)."',
																				 '".$userBasicData->role."',
																				 'C')");
		if(!$this->result) {
			$this->util->db->Execute("DELETE FROM cc_user_tbl WHERE cc_user_id_fld = '".$userBasicData->user."'");
			$respCode = 1;
		}
		return $respCode;
	}

	function getUser($user) {
		$this->result = $this->util->db->Execute("SELECT cc_psswrd_fld AS password,
														 cc_user_id_fld AS user,
														 cc_role_fld AS role,
														 cc_estado_fld AS state
												  FROM cc_user_tbl
												  WHERE cc_user_id_fld = '".$user."'");
	}

	function modifyUser($userData) {
		$respCode = 0;
		$userBasicData = $userData->userFormBasicData->userFormBasic;
		if($userBasicData->state == 'C') {
			$this->result = $this->util->db->Execute("UPDATE cc_user_tbl SET cc_psswrd_fld = '".md5($userBasicData->user)."',
																			 cc_role_fld = '".$userBasicData->role."',
																			 cc_estado_fld = '".$userBasicData->state."'
													  WHERE cc_user_id_fld = '".$userBasicData->user."'");
			if(!$this->result) {
				$respCode = 1;
			}
		}
		else {
			$this->result = $this->util->db->Execute("UPDATE cc_user_tbl SET cc_role_fld = '".$userBasicData->role."',
																			 cc_estado_fld = '".$userBasicData->state."'
													  WHERE cc_user_id_fld = '".$userBasicData->user."'");
			if(!$this->result) {
				$respCode = 1;
			}
		}
		return $respCode;
	}

	function modifyUserPass($userData) {
		$respCode = 0;
		$userBasicData = $userData->loginFormBasicData->loginFormBasic;
		$this->result = $this->util->db->Execute("UPDATE cc_user_tbl SET cc_psswrd_fld = '".md5($userBasicData->password)."',
																		 cc_estado_fld = 'A'
												  WHERE cc_user_id_fld = '".$userBasicData->user."'");
		if(!$this->result) {
			$respCode = 1;
		}
		return $respCode;
	}
 }
?>
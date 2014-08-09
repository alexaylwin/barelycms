<?php
/*
 * The User class represents an authenticated 
 * user for the system.
 */

 
class User
{
	
	private $username;
	private $pagePermissions = Array();
	private $type;
	private $password;
	
	public function __construct($username, $type)
	{
		$this->username = $username;
		$this->type = $type;
	}
	
	public function addPagePermission($page, $pagePermissions)
	{
		$this->pagePermissions[$page] = $pagePermissions;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getUsername()
	{
		return $this->username;	
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public function getPagePermission($page)
	{
		if(isset($this->pagePermissions[$page]))
		{
			return $this->pagePermissions[$page];
		} else {
			$emptyperm = new PagePermissions(array(
				PagePermissions::c_pagename => $page,
				PagePermissions::c_actionPermissions => array(
					'all' => ActionPermissions::Undefined
					)
			));
			return $emptyperm;
		}
	}
	
}

?>
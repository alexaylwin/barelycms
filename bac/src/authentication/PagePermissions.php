<?php

/*
 * This class contains the permissions that a user has
 * for a certain page.
 */
 
class PagePermissions
{
	const c_pagename = "pagename";
	const c_actionPermissions = "actionPermissions";
	private $pagename;
	
	/*
	 * This array will have the following format:
	 * 	action => {ActionPermissions::Allowed, ActionPermissions::Denied}
	 */
	private $actionPermissions = array();
	
	public function __construct($permissionArgs)
	{
		if(isset($permissionArgs[PagePermissions::c_pagename]))
		{
			$this->setPageName($permissionArgs[PagePermissions::c_pagename]);
		}
		
		if(isset($permissionArgs[PagePermissions::c_actionPermissions]))
		{
			$this->setActionPermissions($permissionArgs[PagePermissions::c_actionPermissions]);
		}
	}
	
	public function getPagename()
	{
		return $this->pagename;
	}
	
	public function setPagename($pagename)
	{
		$this->pagename = $pagename;
	}
	
	//This function will parse an actionPermissions array
	public function setActionPermissions($actionPermissions)
	{
		foreach($actionPermissions as $action => $actionValue)
		{
			if(ActionPermissions::isValidValue($actionValue))
			{
				$this->actionPermissions[$action] = $actionValue;
			} else {
				$this->actionPermissions[$action] = ActionPermissions::Undefined;
			}
		}
	}
	
	public function checkAction($action)
	{
		if(isset($this->actionPermissions[$action]))
		{
			return $this->actionPermissions[$action];
		} else {
			return ActionPermissions::Undefined;
		}
	}
	
	public function getActionPermissions()
	{
		return $this->actionPermissions;
	}
	
}

?>
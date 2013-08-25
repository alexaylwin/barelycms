<?php

abstract class CodeBehindScript
{
	
	abstract function handleView($data);
	abstract function handlePost($data);
	abstract function handleAjax($data);

}

?>
<?php

abstract class CodeBehindScript
{
	
	abstract function handleView();
	abstract function handlePost($data);
	abstract function handleAjax($data);

}

?>
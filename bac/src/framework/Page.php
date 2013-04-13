<?php
class Page {
	private $pageid;
	private $containerlist;

	public function __construct($page) {
		$this -> pageid = $page;
		$this -> loadAllContainers();
	}

	public function getPageId() {
		return $this -> pageid;
	}

	public function hasContainers() {
		return (count($this -> containerlist) > 0);
	}

	/**
	 * This returns the container with the given
	 * cotnainer id or null if it doesn't exist
	 */
	public function getContainer($containerid) {
		try {
			$container = $this -> containerlist[$containerid];
			return $container;
		} catch (Exception $e) {
			return;
		}

	}

	public function getAllContainers() {
		return $this -> containerlist;
	}

	/**
	 * This loads all the pages containers into
	 * it's container array
	 */
	public function loadAllContainers() {
		//$containers = scandir('../container_content/pages/' . $this->pageid);
		$containers = scandir(Constants::GET_PAGES_DIRECTORY() . '/' . $this -> pageid);
		//print_r($containers);
		unset($containers[0]);
		unset($containers[1]);

		foreach ($containers as $containerid) {
			$containerid = explode('.', $containerid);
			$new_c = new Container($this -> pageid . '.php', $containerid[0]);
			$this -> containerlist[$containerid[0]] = $new_c;
		}
	}

	public function addContainer($containerid) {
		if (!isset($this -> containerlist[$containerid])) {
			//make a path
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this -> pageid . "/" . $containerid . ".incl";
			//if it doesn't exist, we can make it
			if (!file_exists($path)) {
				$fhandlew = fopen($path, 'w');
				$res = fwrite($fhandlew, "");
				if (!$res) {
					//error
					return false;
				}
			} else {
				return false;
			}

			$this -> containerlist[$containerid] = new Container($this -> pageid . '.php', $containerid);
			return true;
		} else {
			return false;
		}

	}

	public function removeContainer($containerid) 
	{
		if(isset($this->containerlist[$containerid]))
		{
		//delete this container
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->pageid . "/" . $containerid . ".incl";
		$res = unlink($path);
		if (!$res) {
			return false;
		}
		unset($this->containerlist[$containerid]);
		return true;
		} else {
			return false;
		}
	}

}
?>

<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class Log {
	private $handle;

	public function __construct($filename) {
		$this->handle = fopen(DIR_LOGS . $filename, 'a');
	}

	public function write($message) {
		fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
	}

	public function __destruct() {
		fclose($this->handle);
	}
}
<?php

class AccessManager {

	public static function makeExpiry($units, $unit, $format = 'Y-m-d H:i:s')
	{
		$val = Carbon::now();
		$add = "add".$unit;
		$val->$add( $units );
		return $val->format($format);
	}
}
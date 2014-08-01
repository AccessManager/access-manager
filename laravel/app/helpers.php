<?php

	function mikrotikRateLimit($object, $prefix = NULL)
	{
		$v = (array) $object;
		
		return 	       "{$v[$prefix.'max_up']}{$v[$prefix.'max_up_unit'][0]}/".
                       "{$v[$prefix.'max_down']}{$v[$prefix.'max_down_unit'][0]} ".
                       "{$v[$prefix.'max_up']}{$v[$prefix.'max_up_unit'][0]}/".
                       "{$v[$prefix.'max_down']}{$v[$prefix.'max_down_unit'][0]} ".
                       "{$v[$prefix.'max_up']}{$v[$prefix.'max_up_unit'][0]}/".
                       "{$v[$prefix.'max_down']}{$v[$prefix.'max_down_unit'][0]} ".
                       "1/1 1 ".
                       "{$v[$prefix.'min_up']}{$v[$prefix.'min_up_unit'][0]}/".
                       "{$v[$prefix.'min_down']}{$v[$prefix.'min_down_unit'][0]}";
	}
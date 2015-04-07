<?php

class Subnet extends BaseModel {

	protected $table = 'ip_subnets';
	protected $fillable = ['subnet'];
	public $timestamps = FALSE;

	public static function add($cidr)
	{
		// pr($subnet);
		DB::transaction(function()use($cidr){
			$subnet = new self(['subnet'=>$cidr]);

			if ( ! $subnet->save() )			throw new Exception("Failed to create subnet.");

			$network = IPTools\Network::parse($cidr);
			foreach( $network as $ip) {
				$range[] = [
							 'subnet_id'		=>	$subnet->id,
									'ip'		=>	ip2long((string)$ip),
				];
			}
			if( ! SubnetIP::insert($range) ) throw new Exception("Failed to insert IP range.");
		});

	}

	public static function remove($id)
	{
		DB::transaction(function()use($id){
			$subnet = Subnet::findOrFail($id);
			$q = SubnetIP::where('subnet_id', $subnet->id)
							->whereNotNull('user_id');
			$count = $q->count();
			if( $count > 0 )	throw new Exception("<b>CANNOT DELETE</b>. $count accounts have IPs from this subnet.");

			if( ! $subnet->delete() )	throw new Exception("Failed to delete subnet");

			$q = SubnetIP::where('subnet_id',$subnet->id);
			if( $q->count() > 0 && ! $q->delete() )	throw new Exception("Failed to delete associated IP range.");
		});
	}

	public static function assignIP($user_id, $ip_id)
	{
		DB::transaction(function() use ($user_id, $ip_id) {
			$framed_ip = SubnetIP::findOrFail($ip_id);
			SubnetIP::where('user_id', $user_id)->update(['user_id'=>NULL]);
			$framed_ip->user_id = $user_id;
			$framed_ip->assigned_on = date('Y-m-d H:i:s');
			if( ! $framed_ip->save() )	throw new Exception("Could not assign IP.");
		});
	}

}
//end of file Subnet.php
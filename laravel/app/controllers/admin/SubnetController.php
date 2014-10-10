<?php

class SubnetController extends AdminBaseController {

	const HOME = 'subnet.index';

	public function getIndex()
	{

		return View::make("admin.subnet.index")
					->with('subnets', Subnet::paginate(10));
	}

	public function getAddSubnet()
	{
		return View::make('admin.subnet.add-edit');
	}

	public function postAddSubnet()
	{
		try{
			$input = Input::only(['subnet']);
			Subnet::add($input['subnet']);
			$this->notifySuccess("New Subnet added: <b>{$input['subnet']}</b>");
		}
		catch( Exception $e ) {
			$this->notifyError($e->getMessage());
			return Redirect::route( self::HOME );
		}
			return Redirect::route( self::HOME );
	}

	public function getEditSubnet($id)
	{
		echo "SUBNET Cannot be edited.";
	}

	public function postEditSubnet()
	{

	}

	public function postDeleteSubnet($id)
	{
		try{
			Subnet::remove($id);
			$this->notifySuccess("Subnet Deleted.");
		}
		catch(Exception $e) {
			$this->notifyError($e->getMessage());
			return Redirect::route(self::HOME);
		}
		return Redirect::route(self::HOME);
	}

	public function getAssignIP($user_id)
	{
		$profile = Subscriber::findOrFail($user_id);
		$subnets = Subnet::lists('subnet','id');
		$subnets[0] = 'Select';
		// pr($subnets);
		return View::make('admin.subnet.assign-ip')
					->with('profile',$profile)
					->with('subnets',$subnets);
	}

	public function postAssignIP()
	{
		try{
			$user_id = Input::get('user_id', 0);
			$ip_id = Input::get('framed_ip', 0);
			Subnet::AssignIP($user_id, $ip_id);
			$this->notifySuccess("IP Assigned.");
		}
		catch(Exception $e ) {
			$this->notifyError($e->getMessage());
			return Redirect::route('subscriber.services', $user_id);
		}
		return Redirect::route('subscriber.services', $user_id);
	}

	public function getDeleteIp($ip_id)
	{
		SubnetIP::where('id',$ip_id)->update(['user_id'=>NULL]);
		$this->notifySuccess("Static IP de-assigned.");
		return Redirect::back();
	}

	public function getAssignRoute($user_id)
	{
		$user = Subscriber::findOrFail($user_id);
		return View::make("admin.subnet.assign-route")
					->with('profile',$user);
	}

	public function postAssignRoute()
	{
		$user_id = Input::get('user_id',0);
		$subnet = Input::get('subnet');
		$route = UserRoute::firstOrNew(['user_id'=>$user_id]);
		$route->subnet = $subnet;
		if( $route->save() ) {
			$this->notifySuccess("Route assigned successfully.");
		} else {
			$this->notifyError("Failed to assign route.");
		}
		return Redirect::route('subscriber.services', $user_id);
	}

	public function getDeleteRoute($route_id)
	{
		if( UserRoute::destroy($route_id)) {
			$this->notifySuccess('Route Deleted.');
		} else {
			$this->notifyError("Failed to delete route.");
		}
		return Redirect::back();
	}

	public function getUsedIPs($subnet_id)
	{
		$ips = DB::table("ip_subnets as s")
					->join("subnet_ips as i",'s.id','=','i.subnet_id')
					->leftJoin('user_accounts as u','u.id','=','i.user_id')
					->where('s.id',$subnet_id)
					->select("u.uname",'i.ip')
					->paginate(100);

		return View::make('admin.subnet.subnet-usage')
					->with('ips',$ips);
	}


}
//end of file SubnetController.php
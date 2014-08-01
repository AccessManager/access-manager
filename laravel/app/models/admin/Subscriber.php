<?php

Class Subscriber extends BaseModel {

	protected $table = 'user_accounts';
	protected $fillable = ['uname','clear_pword','pword','fname','lname','contact','email','address','status',];

	public function recharge()
	{
		return $this->hasOne('Recharge', 'user_id');
	}

	public function rechargeHistory()
	{
		return $this->hasMany('Voucher', 'user_id');
	}

	public function sessionHistory()
	{
		return $this->hasMany('RadAcct', 'username', 'uname');
	}

	// public static function addAccount($input)
	// {
	// 	$account = new Subscriber;
	// 	$account->fill($input);

	// 	if( ! $account->save() ) {
	// 		throw new Exception("Account creation failed.");
	// 	}
	// }
}
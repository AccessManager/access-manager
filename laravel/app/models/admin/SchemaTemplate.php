<?php

Class SchemaTemplate extends BaseModel {
	protected $table = 'policy_schema_templates';
	protected $fillable = ['name','access','bw_policy','from_time','to_time','pr_allowed','pr_policy','pr_accountable',
							'sec_allowed','sec_policy','sec_accountable'];
	public $timestamps = FALSE;							
}
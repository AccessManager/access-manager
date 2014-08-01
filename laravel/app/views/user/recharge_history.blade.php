@extends('user.header_footer')
@section('user_title')
Recharge History
@stop

@section('user_container')
	

	<table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Plan</th>
                                <th>Plan Type</th>
                                <th>Time Limit</th>
                                <th>Data Limit</th>
                                <th>Recharged On</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($rc_history))
                            <?php $i = $rc_history->getFrom(); ?>
                            @foreach($rc_history as $voucher)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$voucher->plan_name}}</td>
                                <td>{{$voucher->plan_type == 1 ? 'Limited' : 'Unlimited'}}</td>
                                <td>
                                    @if(isset($voucher->limits))
                                    {{$voucher->limits->time_limit}} {{$voucher->limits->time_unit}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($voucher->limits))
                                    {{$voucher->limits->data_limit}} {{$voucher->limits->data_unit}}
                                    @endif
                                </td>
                                <td>{{date("d M'y H:i", strtotime($voucher->updated_at))}}</td>
                                <td>{{$voucher->method}}</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='7'>No Records Found.</td>
                            </tr>
                            @endif
                        </tbody>
                        
                    </table>

<div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$rc_history->links()}}
                </div>
            </div>
@stop
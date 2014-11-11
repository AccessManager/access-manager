@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>
                        <i class="fa fa-tags"></i>
                        Prepaid Vouchers
{{HTML::link(route('voucher.generate.form'), 'Generate Vouchers', ['class'=>'btn btn-primary navbar-right','data-toggle'=>'modal'])}}
                    </h2>
                </div>

            </div>
            
            <hr />
            @if(count($vouchers))
            {{Form::open(['route'=>'voucher.handle'])}}
            {{Form::hidden('type','prepaid_voucher')}}
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                @if(count($vouchers))
                                <th>
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                @endif
                                <th>#</th>
                                <th>Service Plan</th>
                                <th>Recharge PIN</th>
                                <th>Service Validity</th>
                                <th>Created On</th>
                                <th>Expires On</th>
                                <th>Used By</th>
                                <th>Used On</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($vouchers))

                            <?php $i = $vouchers->getFrom(); ?>
                            @foreach($vouchers as $voucher)
                            <tr>
                                <td>
                                    <input type="checkbox" name="vouchers[]" value="{{$voucher->id}}" class="checkbox fa fa-square-o">
                                </td>
                                <td>{{$i}}</td>
                                <td><a href="">{{$voucher->name}}</a></td>
                                <td>{{$voucher->pin}}</td>
                                <td>{{$voucher->validity}} {{$voucher->validity_unit}}</td>
                                <td>{{date("d-M-y", strtotime($voucher->created_at))}}</td>
                                <td>{{date("d-M-y", strtotime($voucher->expires_on))}}</td>
                                <td>{{($voucher->uname) ? $voucher->uname : NULL}}</td>
                                <td>
                                    {{strtotime($voucher->updated_at) == 0 ? 'Unused' : date('d-M-y',strtotime($voucher->updated_at))}}
                                </td>
                                <td>{{$voucher->method}}</td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="9">No records Found.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            $disabled = 'disabled';
            if(count($vouchers)) {
                $disabled = NULL;
            }
            ?>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            {{Form::submit('Print', ['class'=>"btn btn-xs btn-default $disabled",'name'=>'print'])}}
                    {{Form::submit('Destroy', ['class'=>"btn btn-xs btn-danger $disabled",'name'=>'destroy'])}}
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    {{$vouchers->links()}}
                </div>
            </div>
            @if(count($vouchers))
            {{Form::close()}}
            @endif
        <!-- </div> -->
@stop
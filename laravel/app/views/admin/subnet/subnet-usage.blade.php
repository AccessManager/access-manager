@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>All Subnets
                            {{link_to_route('subnet.add.form', 'New Subnet', NULL, ['class'=>'btn btn-primary navbar-right',])}}
                    </h2>
                </div>
            </div>
            <!-- <div class="container"> -->
            
            <hr />
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subnet</th>
                                <th>Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($ips))
                            <?php $i = $ips->getFrom();?>
                            @foreach($ips as $ip)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{long2ip($ip->ip)}}</td>
                                <td>
                                    {{$ip->uname}}
                                </td>
                        </tr>
                        <?php  $i++;  ?>
                        @endforeach
                        @else
                        <tr>
                            <td colspan=7>
                                No Records Found
                            </td>
                        </tr>
                        @endif
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$ips->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($subnets))
                            <?php $i = $subnets->getFrom();?>
                            @foreach($subnets as $subnet)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$subnet->subnet}}</td>
                                <td>
                                    {{Form::actions(
                                        route('subnet.edit.form',$subnet->id),
                                        route('subnet.delete',$subnet->id)
                                        )}}
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
                    {{$subnets->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
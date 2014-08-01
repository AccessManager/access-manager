@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>All Policies
                            {{link_to_route('policy.add.form', 'New Bandwidth Policy', NULL, ['class'=>'btn btn-primary navbar-right',])}}
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
                                <th>Policy Name</th>
                                <th>Max Download</th>
                                <th>Min Download</th>
                                <th>Max Upload</th>
                                <th>Min Upload</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($policies))
                            <?php $i = $policies->getFrom();?>
                            @foreach($policies as $policy)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$policy->name}}</td>
                                <td>{{$policy->max_down}} {{$policy->max_down_unit}}</td>
                                <td>{{$policy->min_down}} {{$policy->min_down_unit}}</td>
                                <td>{{$policy->max_up}} {{$policy->max_up_unit}}</td>
                                <td>{{$policy->min_up}} {{$policy->min_up_unit}}</td>
                                <td>
                                    {{Form::actions(
                                        route('policy.edit.form',$policy->id),
                                        route('policy.delete',$policy->id)
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
                    {{$policies->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
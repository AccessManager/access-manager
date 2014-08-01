@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>
                        <i class="fa fa-codepen"></i>
                        Service Plans
                        {{HTML::link(route('plan.add.form'), 'New Service Plan', ['class'=>'btn btn-primary navbar-right',])}}
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
                                <th>Plan Name</th>
                                <th>Plan Type</th>
                                <th>Bandwidth Policy</th>
                                <th>Time Limit</th>
                                <th>Data Limit</th>
                                <th>After Quota</th>
                                <th>Validity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if(count($plans))
                          <?php $i = $plans->getFrom(); ?>
                          @foreach($plans as $plan)
                          
                            <tr>
                                <td>{{$i}}</td>
                                <td><a href="">{{$plan->name}}</a></td>
                                <td><?php
                                echo ($plan->plan_type ) ? 'Limited' : 'Unlimited';
                                ?></td>
                                <td>{{$plan->policy->name}}</td>
                                
                                <td>
                                @if(isset($plan->limit))
                                    {{$plan->limit->time_limit}} {{$plan->limit->time_unit}}
                                @endif
                                </td>
                                <td>
                                @if(isset($plan->limit))
                                    {{$plan->limit->data_limit}} {{$plan->limit->data_unit}}
                                @endif
                                </td>
                                <td>
                                @if(isset($plan->limit))
                                    {{($plan->limit->aq_access) ? 'Allowed' : 'Not Allowed'}}
                                @endif
                                </td>
                                <td>{{$plan->validity}} {{$plan->validity_unit}}</td>
                                <td>
                                    {{Form::actions(
                                        route('plan.edit.form',$plan->id),
                                        route('plan.delete',$plan->id)
                                        )}}
                                </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                        @else
                        <tr>
                          <td colspan='9'>No Records Found.</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$plans->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
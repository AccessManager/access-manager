@extends('admin.header_footer')
@section('admin_container')
<?php 
$all_acct_class = Input::get('alphabet', NULL) == NULL ? 'active' : NULL;
?>
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>Active Sessions</h2>
                </div>
            </div>
            <!-- <div class="container"> -->

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="nav nav-pills">
                        <li class="{{$all_acct_class}}"><a href="{{route('subscriber.active')}}">All Accounts</a></li>

                        @foreach(range('a','z') as $a)
                        <?php 
                            $class = Input::get('alphabet', NULL) == $a ? 'active' : NULL ;
                        ?>
                            <li class ="{{$class}}">
                                <a href="{{route('subscriber.active') . '?' . http_build_query(array_merge(Input::except('alphabet'),['alphabet'=>$a]))}}">{{$a}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Service Plan</th>
                                <th>Online Since</th>
                                <th>Validity Expires</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($active))
                            <?php $i = $active->getFrom(); ?>
                            @foreach($active as $account)
                            <?php $plan = $plans[$account->session_id]; ?>
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    {{link_to_route('subscriber.profile',$account->uname,$account->id)}}
                                </td>
                                <td>{{$account->fname}} {{$account->lname}}</td>
                                <td>{{$account->contact}}</td>
                                <td>{{$plan->plan_name}}</td>
                                <td>{{$account->acctstarttime}}</td>
                                <td>{{$plan->expiration}}</td>
                                <td>
                                {{Form::open(['route'=>'subscriber.disconnect'])}}
                                    {{Form::hidden('session_id',$account->session_id)}}
                                    <button type="submit" class="btn btn-danger btn-xs">
                                    <i class="fa fa-unlink"></i> disconnect</button>    
                                {{Form::close()}}
                                
                                    </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='8'>No Records Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <button href="{{route('clear-stale-sessions')}}" class='btn btn-sm btn-danger'>Clear Stale Sessions</button>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    {{$active->appends(Input::except('page'))->links()}}
                </div>
            </div>
        <!-- </div> -->
@stop
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

                        @for($i=97; $i<=122; $i++)
                        <?php 
                            $class = Input::get('alphabet', NULL) == chr($i) ? 'active' : NULL ;
                        ?>
                            <li class ="{{$class}}">
                                <a href="{{route('subscriber.active') . '?' . http_build_query(array_merge(Input::except('alphabet'),['alphabet'=>chr($i)]))}}">{{chr($i)}}</a>
                            </li>
                        @endfor
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
                            <tr>
                                <td>{{$i}}</td>
                                <td><a href="">{{$account->uname}}</a></td>
                                <td>{{$account->fname}} {{$account->lname}}</td>
                                <td>{{$account->contact}}</td>
                                <td>{{$account->plan_name}}</td>
                                <td>{{$account->acctstarttime}}</td>
                                <td>{{$account->expiration}}</td>
                                <td><button type="button" class="btn btn-danger btn-xs">
                                    <i class="fa fa-unlink"></i> disconnect</button></td>
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
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$active->appends(Input::except('page'))->links()}}
                </div>
            </div>
        <!-- </div> -->
@stop
@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>All Routers
                        {{link_to_route('router.add', 'New Router', NULL, ['class'=>'btn btn-primary navbar-right',])}}
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
                                <th>Short Name</th>
                                <th>IP Address</th>
                                <th>Secret</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($routers))
                            <?php $i = $routers->getFrom();?>
                            @foreach($routers as $router)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$router->shortname}}</td>
                                <td>{{$router->nasname}}</td>
                                <td>{{$router->secret}}</td>
                                <td>{{$router->description}}</td>
                                <td>
                                    {{Form::actions(
                                        route('router.edit.form',$router->id),
                                        route('router.delete',$router->id)
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
                    {{$routers->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
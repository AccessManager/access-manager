@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>All Organisation
                            {{link_to_route('org.add.form', 'Add Organisation', NULL, ['class'=>'btn btn-primary navbar-right',])}}
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
                                <th>Organisation Name</th>
                                <th>Address</th>
                                <th>TIN</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($organisations))
                            <?php $i = $organisations->getFrom();?>
                            @foreach($organisations as $org)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$org->name}}</td>
                                <td>{{$org->address}}</td>
                                <td>{{$org->tin}}</td>
                                <td>
                                    {{Form::actions(
                                        route('org.edit.form',$org->id),
                                        route('org.delete',$org->id)
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
                    {{$organisations->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
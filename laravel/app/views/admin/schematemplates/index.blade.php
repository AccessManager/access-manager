@extends('admin.header_footer')
@section('admin_container')
	<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>Schema Templates
                        {{link_to_route('schematemplate.add', 'New Schema Template', NULL, ['class'=>'btn btn-primary navbar-right',])}}
                    </h2>
                </div>
                
            </div>
            
            <hr />

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Schema Name</th>
                                <th>Description</th>
                                <th>Actions</ths>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($templates) )
                            <?php $i = $templates->getFrom(); ?>
                                @foreach($templates as $template)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$template->name}}</td>
                                <td>{{$template->description}}</td>
                                <td>
                                    {{Form::actions(
                                        route('schematemplate.edit.form',$template->id),
                                        route('schematemplate.delete',$template->id)
                                        )}}
                                </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                        @else
                        <tr>
                            <td colspan='4'>
                            {{"No Records Found"}}
                                
                            </td>
                        </tr>
                        @endif
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    	{{$templates->links()}}
                </div>
            </div>

        <!-- </div> -->
@stop
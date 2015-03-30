<table class="table table-stripped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Added On</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    	@if( count($nrproducts) )
    	<?php $i =1; ?>
			@foreach($nrproducts as $nrproduct)
    			<tr>
    				<td>{{$i}}</td>
    				<td>{{$nrproduct->name}}</td>
    				<td>{{$nrproduct->price}}</td>
    				<td>{{date('d M y',strtotime($nrproduct->assigned_on))}}</td>
    				<td>
    					{{Form::open(['route'=>['product.delete.nonrecurring']])}}
                {{Form::hidden('id',$nrproduct->id)}}
                    {{Form::button('modify',['class'=>'btn btn-default btn-xs','data-target'=>'#nrproduct'.$nrproduct->id,'data-toggle'=>'modal'])}}
                    {{Form::delete()}}
                    {{Form::close()}}
    				</td>
    			</tr>
    		@endforeach
    	@else
			<tr>
				<td colspan="4">No Records Found</td>
			</tr>

    	@endif
    </tbody>
</table>
@foreach($nrproducts as $nrproduct)
	@include('admin.accounts.partials.edit_non_recurring_product_modal',['nrproduct'=>$nrproduct])
@endforeach
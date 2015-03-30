<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Billed Every</th>
                <th>Assigned On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @if( count($rproducts) )
        <?php $i = 1; ?>
        @foreach($rproducts as $rproduct)
            <tr>
                <td>{{$i}}</td>
                <td>{{$rproduct->name}}</td>
                <td>{{$rproduct->price}}</td>
                <td>{{$rproduct->billing_cycle . $rproduct->billing_unit}}</td>
                <td>{{date('d M y', strtotime($rproduct->assigned_on))}}</td>
                <td>
                {{Form::open(['route'=>['product.delete.recurring']])}}
                {{Form::hidden('id',$rproduct->id)}}
                    {{Form::button('modify',['class'=>'btn btn-default btn-xs','data-target'=>'#rproduct'.$rproduct->id,'data-toggle'=>'modal'])}}
                    {{Form::delete()}}
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
        @else
            <td colspan="5">No Records Found.</td>
        @endif
        </tbody>
    </table>

    @foreach($rproducts as $rproduct)
        @include('admin.accounts.partials.edit_recurring_product_modal',['rproduct'=>$rproduct])
    @endforeach
@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Products</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Products</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
                            <a href="{{route('add.product')}}"  class="btn btn-primary">Add Product</a>



						</div>
					</div>
				</div>
				<!--end breadcrumb-->

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
			<tr>
				<th>Sl</th>
				<th>Image </th>
				<th>Product Name</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Discount</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
	@foreach($products as $key => $item)
			<tr>
				<td> {{ $key+1 }} </td>

				<td> <img src="{{ asset($item->product_thumbnail) }}" style="width: 70px; height:40px;" >  </td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->selling_price }}</td>
                <td>{{ $item->product_qty }}</td>
                <td>{{ $item->discount_price }}</td>
                <td>{{ $item->status }}</td>

				<td>

    <form action="{{ route('delete.category',$item->id) }}" method="Post">
        <a class="btn btn-primary" href="{{ route('edit.category',$item->id) }}">Edit</a>
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" id="delete" >Delete</button>
    </form>

				</td>
			</tr>
			@endforeach


		</tbody>
		<tfoot>
			<tr>
				<th>Sl</th>
				<th>Image </th>
				<th>Product Name</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Discount</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>



			</div>




@endsection

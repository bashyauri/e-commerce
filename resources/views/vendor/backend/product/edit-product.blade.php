@extends('vendor.vendor_dashboard')
@section('vendor')
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">eCommerce</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Vendor Product</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Edit Vendor Product</h5>
          <hr/>
          @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form id="myForm" action="{{ route('vendor.update-product', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
           <div class="form-body mt-4">
            <div class="row">


               <div class="col-lg-8">
               <div class="border border-3 p-4 rounded">

                <div class="form-group mb-3">
                    <label for="inputProductTitle" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="{{$product->product_name}}">
                </div>

                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Product Tags</label>
                    <input type="text" name="product_tags" class="form-control visually-hidden" data-role="tagsinput" value="{{ $product->product_tags }}">
                  </div>
                <div class="form-group mb-3">
                    <label for="inputProductTitle" class="form-label">Product Size</label>
                    <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput" value="{{$product->product_size}}">
                </div>
                <div class="form-group mb-3">
                    <label for="inputProductTitle" class="form-label">Product Color</label>
                    <input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput" value={{$product->product_color}}>
                </div>
                  <div class="form-group mb-3">
                    <label  for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea  name="short_descp" class="form-control" id="inputProductDescription" rows="3">
                    {{$product->short_descp}}
                    </textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                    <textarea id="mytextarea" name="long_descp" class="form-control" id="inputProductDescription" rows="3">
                        {!!$product->long_descp !!}
                    </textarea>
                  </div>





                </div>
               </div>
               <div class="col-lg-4">
                <div class="border border-3 p-4 rounded">
                  <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="inputPrice" class="form-label">Product Price</label>
                        <input type="text" name="selling_price" class="form-control" id="inputPrice" value="{{$product->selling_price}}">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputCompareatprice" class="form-label">Discount Price</label>
                        <input type="text" name="discount_price" class="form-control" id="inputCompareatprice" value="{{$product->discount_price}}">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputCostPerPrice" class="form-label">Product Code</label>
                        <input type="text" name="product_code" class="form-control" id="inputCostPerPrice" value="{{$product->product_code}}">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputStarPoints" class="form-label">Product Quantity</label>
                        <input type="text" name = "product_qty" class="form-control" id="inputStarPoints" value={{$product->product_qty}}>
                      </div>

                      <div class="form-group col-12">
                        <label for="inputProductType" class="form-label">Product Brand</label>
                        <select name="brand_id" class="form-select" id="inputProductType">
                            <option></option>
                            @foreach ($brands as $brand)
                            <option value="{{$brand->id}}" {{$brand->id == $product->brand_id ? "selected" : ""}}>{{$brand->brand_name}}</option>
                            @endforeach


                          </select>
                      </div>

                      <div class="form-group col-12">
                        <label for="inputVendor" class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" id="inputVendor">
                            <option></option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{$category->id == $product->category_id ? "selected" : ""}}>{{$category->category_name}}</option>
                            @endforeach


                          </select>
                      </div>
                      <div class="col-12">
                        <label for="inputCollection" class="form-label">Product SubCategory</label>
                        <select name="sub_category_id" class="form-select" id="inputCollection">
                            <option></option>
                            <option></option>
                            @foreach ($subcategories as $subcategory)
                            <option value="{{$subcategory->id}}" {{$subcategory->id == $product->sub_category_id ? "selected" : ""}}>{{$subcategory->subcategory_name}}</option>
                            @endforeach

                          </select>
                      </div>
                      <div class="col-12">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="hot_deals" type="checkbox" value="1" {{$product->hot_deals == '1' ? 'checked' : ''}} id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Hot deals</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="featured" type="checkbox" value="1" {{$product->featured == '1' ? 'checked' : ''}} id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Featured</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="special_offer" type="checkbox" value="1" {{$product->special_offer == '1' ? 'checked' : ''}} id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Special Offer</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="special_deals" type="checkbox" value="1" {{$product->special_deals == '1' ? 'checked' : ''}} id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Special Deals</label>
                        </div>
                    </div>
                </div>
                    </div>
                    <hr>
                      <div class="col-12">
                          <div class="d-grid">
                             <button type="submit" class="btn btn-primary">Update Product</button>
                          </div>
                      </div>
                  </div>
              </div>
              </div>

           </div><!--end row-->
        </div>
    </form>
      </div>
  </div>
  {{-- Starts Image Thumbnail --}}
  <h6 class="mb-0 text-uppercase">Update Image Thumbnail</h6>
  <hr>
  <div class="card">
    <div class="card-body">
        <form  action="{{ route('vendor.update.product-thumbnail', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="old_image" value="{{$product->product_thumbnail}}" />
            <div class="mb-3">
                <label for="formFile" class="form-label">Select Thumbnail</label>
                <input class="form-control" name="product_thumbnail" type="file" id="formFile" onChange="mainThumbnailUrl(this)">
            </div>
            <div class="mb-3">

                <img src="{{asset($product->product_thumbnail) }}" style="width:100px;height:100px;" id="mainThumbnail">
            </div>
            <button type="submit" class="btn btn-primary">Update Thumbnail</button>
        </form>
    </div>
</div>
{{-- End Image Thumbnail --}}
{{-- Start Images --}}
<h6 class="mb-0 text-uppercase">Update Images</h6>
  <hr>
<div class="card">
							<div class="card-body">
								<table class="table mb-0 table-striped">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Image</th>
											<th scope="col">Change Image</th>
											<th scope="col">Delete</th>
										</tr>
									</thead>
									<tbody>

                                        @foreach ($images as $index => $image)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td><img src="{{ asset($image->photo_name) }}" alt="" style="width: 70px; height: 40px;"></td>
                                            <td>
                                                <form action="{{ route('vendor.update.product-image', $image->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="file" class="form-group" name="photo_name">
                                                    <button type="submit" class="btn btn-primary">Update Image</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('delete.product-image', $image->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" id="delete" title="Delete Image">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach




									</tbody>
								</table>
							</div>
						</div>
</div>
{{-- End Images --}}


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>






<script type="text/javascript">


 $(document).ready(function(){
  $('#images').on('change', function(){ //on file input change
     if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
     {
         var data = $(this)[0].files; //this file data

         $.each(data, function(index, file){ //loop though each file
             if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                 var fRead = new FileReader(); //new filereader
                 fRead.onload = (function(file){ //trigger function on successful read
                 return function(e) {
                     var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                 .height(80); //create image element
                     $('#image_preview').append(img); //append image to output element
                 };
                 })(file);
                 fRead.readAsDataURL(file); //URL representing the file's data.
             }
         });

     }else{
         alert("Your browser doesn't support File API!"); //if File API is absent
     }
  });
 });

function mainThumbnailUrl(input) {
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
        $('#mainThumbnail').attr('src',e.target.result).width(80).height(80);
        };
        reader.readAsDataURL(input.files[0]);

    }
}
    $(document).ready(function() {
        $('#myForm').validate({
            rules: {
                product_name: {
                    required : true,
                },
                 short_descp: {
                    required : true,
                },
                 product_thumbnail: {
                    required : true,
                },
                 images: {
                    required : true,
                },
                 selling_price: {
                    required : true,
                },
                 product_code: {
                    required : true,
                },
                 product_qty: {
                    required : true,
                },
                 brand_id: {
                    required : true,
                },
                 category_id: {
                    required : true,
                },
                 sub_category_id: {
                    required : true,
                },
            },
            messages :{
                product_name: {
                    required : 'Please Enter Product Name',
                },
                short_descp: {
                    required : 'Please Enter Short Description',
                },
                product_thumbnail: {
                    required : 'Please Select Product Thambnail Image',
                },
                images: {
                    required : 'Please Select Product Multi Image',
                },
                selling_price: {
                    required : 'Please Enter Selling Price',
                },
                product_code: {
                    required : 'Please Enter Product Code',
                },
                 product_qty: {
                    required : 'Please Enter Product Quantity',
                },

            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
    $(document).ready(function(){

        $('select[name="category_id"]').on('change', function(){

            var category_id = $(this).val();

            if (category_id) {
                $.ajax({
                    url: "{{ url('/subcategory/ajax') }}/"+category_id,
                    type: "GET",
                    dataType:"json",
                    success:function(data){

                        $('select[name="sub_category_id"]').html('');
                        var d =$('select[name="sub_category_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="sub_category_id"]').append('<option value="'+ value.id + '">' + value.subcategory_name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });
    });


</script>








@endsection

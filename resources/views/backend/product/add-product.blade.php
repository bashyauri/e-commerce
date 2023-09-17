@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">eCommerce</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Add New Product</h5>
          <hr/>
           <div class="form-body mt-4">
            <div class="row">
               <div class="col-lg-8">
               <div class="border border-3 p-4 rounded">
                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Product Name</label>
                    <input type="email" name="product_name" class="form-control" id="inputProductTitle" placeholder="Enter product title">
                </div>
                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Product Tags</label>
                    <input type="text" name="product_tags" class="form-control visually-hidden" data-role="tagsinput" value="New Product,Top Product">
                </div>
                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Product Size</label>
                    <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput" value="Small,Medium,Large">
                </div>
                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Product Color</label>
                    <input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput" value="Red,Blue,Black">
                </div>
                  <div class="mb-3">
                    <label  for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea  name="short_descp" class="form-control" id="inputProductDescription" rows="3"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                    <textarea id="mytextarea" name="long_descp" class="form-control" id="inputProductDescription" rows="3"></textarea>
                  </div>


                  <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Main Thumbnail</label>
                    <input name="product_thumbnail" class="form-control" type="file" id="formFile" multiple="" onChange="mainThumbnailUrl(this)">
                </div>
                <img src="" id="mainThumbnail" />
                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Multiple Images</label>
                    <input name="images[]" class="form-control" type="file" id="formFileMultiple" multiple="">
                </div>

                </div>
               </div>
               <div class="col-lg-4">
                <div class="border border-3 p-4 rounded">
                  <div class="row g-3">
                    <div class="col-md-6">
                        <label for="inputPrice" class="form-label">Product Price</label>
                        <input type="text" name="selling_price" class="form-control" id="inputPrice" placeholder="00.00">
                      </div>
                      <div class="col-md-6">
                        <label for="inputCompareatprice" class="form-label">Discount Price</label>
                        <input type="text" name="discount_price" class="form-control" id="inputCompareatprice" placeholder="00.00">
                      </div>
                      <div class="col-md-6">
                        <label for="inputCostPerPrice" class="form-label">Product Code</label>
                        <input type="text" name="product_code" class="form-control" id="inputCostPerPrice" placeholder="00.00">
                      </div>
                      <div class="col-md-6">
                        <label for="inputStarPoints" class="form-label">Product Quantity</label>
                        <input type="text" name = "product_qty" class="form-control" id="inputStarPoints" placeholder="00.00">
                      </div>

                      <div class="col-12">
                        <label for="inputProductType" class="form-label">Product Brand</label>
                        <select name="brand_id" class="form-select" id="inputProductType">
                            <option></option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                      </div>

                      <div class="col-12">
                        <label for="inputVendor" class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" id="inputVendor">
                            <option></option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                      </div>
                      <div class="col-12">
                        <label for="inputCollection" class="form-label">Product SubCategory</label>
                        <select name="sub_category_id" class="form-select" id="inputCollection">
                            <option></option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                      </div>
                      <div class="col-12">
                        <label for="inputCollection" class="form-label">Select Vendor</label>
                        <select name="vendor_id" class="form-select" id="inputCollection">
                            <option></option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                      </div>
                      <div class="col-12">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="hot_deals" type="checkbox" value="1" id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Hot deals</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="featured" type="checkbox" value="1" id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Featured</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="special_offer" type="checkbox" value="1" id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Special Offer</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" name="special_deals" type="checkbox" value="1" id="flexCheckDefault">

                            <label class="form-check-label" for="flexCheckDefault">Special Deals</label>
                        </div>
                    </div>
                </div>
                    </div>
                    <hr>
                      <div class="col-12">
                          <div class="d-grid">
                             <button type="button" class="btn btn-primary">Save Product</button>
                          </div>
                      </div>
                  </div>
              </div>
              </div>
           </div><!--end row-->
        </div>
      </div>
  </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>






<script type="text/javascript">
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
                    required: true,
                },
            },
            messages: {
                product_name: {
                    required: 'Please Enter Subcategory Name',
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
</script>





@endsection

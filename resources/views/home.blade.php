@extends('layouts.default')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <h3 class="float-left mb-3">Product</h3>
                  <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal" data-target="#addProduct">Add</button>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Picture</th>
                      </tr>
                    </thead>
                    <tbody id="content">
                      @foreach ($products as  $product)
                      <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_desc }}</td>
                        <td> <img class="img-thumbnail" width="50" height="50" src="{{ asset('storage/'.$product->product_picture) }}" alt=""> </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Product Modal -->
<div class="modal fade" id="addProduct">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Product</h4>
        <button id="closeModal" type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="error"></div>
      <form id="productForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
              <label for="product_name">{{ __('Product Name') }}</label>
              <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name') }}"  autocomplete="product_name" autofocus>
              @error('product_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="form-group">
              <label for="product_desc">{{ __('Product Desc') }}</label>
              <textarea id="product_desc" type="text" class="form-control @error('product_desc') is-invalid @enderror" name="product_desc" value="{{ old('product_desc') }}"  autocomplete="product_desc" autofocus></textarea>
              @error('product_desc')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="form-group">
              <label for="product_desc">{{ __('Product Picture') }}</label>
              <input id="product_picture" type="file" class="form-control @error('product_picture') is-invalid @enderror" name="product_picture" accept="image/png, image/jpg, image/jpeg" />
              @error('product_picture')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="form-group">
            <button type="submit" id="saveBtn" class="btn btn-primary float-right">Save</button><br><br>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
  $('#productForm').submit(function(e) {
    e.preventDefault();
       let formData = new FormData(this);
    if( !$.trim($('#product_name').val()) || !$.trim($('#product_desc').val()) || !$.trim($('#product_picture').val()) ) {
      $('.error').html(`<p class='text-danger px-3'>All field are required</p>`);
      return false;
    } else {
      $.ajax({
        url: "{{ route('product-add') }}",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success:function(response) {
          $('#content').append(`<tr>
            <td>`+response.product.id+`</td>
            <td>`+response.product.product_name+`</td>
            <td>`+response.product.product_desc+`</td>
            <td> <img class='img-thumbnail' width='50' height='50' src='{{ asset("storage") }}/`+response.product.product_picture+`' alt=''> </td>
          </tr>`);
          $("#closeModal").trigger("click");
        }
    });
    }
   });
</script>
@endsection

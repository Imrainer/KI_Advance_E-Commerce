<x-layout title="Edit Catalogue | E-Commerce">
   
    <div class="container col-md-5">
      @foreach ( $product as $item)
      <form action="http://localhost/laravel_E-Commerce/public/product/edit-store/{{$product->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit Product </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Nama</label>
          <input type="text" class="form-control"  value="{{$product->name}}" name="name" id="exampleInputEmail1">
        </div>

        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Detail</label>
          <input type="text" class="form-control" name="product_description">
        </div>

        <div class="dropdown">
            <label for="city-select">Category:</label>
            <select class="form-control" id="city-select" name="categories_id">
                <option value="">Select a category</option>
                @foreach ($category as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Harga</label>
            <input type="number" class="form-control" name="price">
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Stock</label>
            <input type="text" class="form-control" name="stock">
          </div>
      
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Foto Thumbnail</label>
        <input type="file" class="form-control" name="photo_thumbnail"   id="exampleInputEmail1">
      </div>
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>



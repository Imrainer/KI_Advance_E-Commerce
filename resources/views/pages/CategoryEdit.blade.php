<x-layout title="Edit Category | Jelajah Nusantara">
   
    <div class="container col-md-5">
      @foreach ( $category as $item)
      <form action="http://localhost/laravel_katalogue/public/category/edit-store/{{$category->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit Category </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Category</label>
          <input type="text" class="form-control"  value="{{$category->category}}" name="category" id="exampleInputEmail1">
        </div>
       
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>



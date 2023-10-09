<x-layout title="Edit Province | E-Commerce">
   
    <div class="container col-md-5">
      @foreach ( $province as $item)
      <form action="http://localhost/laravel_katalogue/public/province/edit-store/{{$province->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit Province </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Province</label>
          <input type="text" class="form-control"  value="{{$province->province}}" name="province" id="exampleInputEmail1">
        </div>
       
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>



<x-layout title="Edit Admin | Jelajah Nusantara">
   
    <div class="container col-md-5">
      @foreach ( $data as $item)
      <form action="http://localhost/laravel_katalogue/public/admin/edit-store/{{$data->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit Admin </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Nama</label>
          <input type="text" class="form-control"  value="{{$data->name}}" name="name" id="exampleInputEmail1">
        </div>
      
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Foto</label>
        <input type="file" class="form-control" name="photo"   id="exampleInputEmail1">
      </div>
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>
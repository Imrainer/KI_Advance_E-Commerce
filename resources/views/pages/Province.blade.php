<x-layout title="Province | E-Commerce">
 
<div class="d-flex">
<x-Sidebar photo="{{$admin->photo}}" name="{{$admin->name}}"></x-Sidebar>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Province</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>    
      <div class="modal-body">
      
        <form action="http://localhost/laravel_katalogue/public/user/add-user" method="POST">
          @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Nama</label>
              <input type="text" class="form-control" name="province">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-outline-success">Submit</button>
            
        </form> 
      </div>

      </div>
    </div>
  </div>
</div>

  <div class=" col-md-10">

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@foreach($errors->all() as $msg)
  <div class="alert alert-danger">{{$msg}}</div>
  @endforeach
  

<div class="mt-5 ms-5 col-md-12 ">

    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-success mb-1 mt-3"><i class="fas fa-user-plus"></i> Add New</button>
    
    <form action="http://localhost/laravel_katalogue/public/province" method="GET" class="col-md-9 mt-3">
      <div class="mb-3 d-flex">
        <i class="fas fa-search mt-2 me-3"></i>
        <input type="search" name="search" class="form-control col-md-5" placeholder="Type here">
        <button class="btn btn-outline-success ms-3">Search</button>
      </div>
    </form>
    
    <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>  
          @php
          $counter = ($province->currentPage() - 1) * $province->perPage() + 1;
            @endphp     
           @foreach ($province as $index => $item)
           <tr>
            <th scope="row">{{ $counter++ }}</th>
            <td>{{$item->province}}</td>
            <td>
            <a href="http://localhost/laravel_katalogue/public/province/edit/{{$item->id}}" class="me-1 fas fa-pen text-primary text-decoration-none"></a>
            <a href="http://localhost/laravel_katalogue/public/province/delete/{{$item->id}}" class="ms-1 fas fa-trash text-danger"></a>  
            <td>
          </tr>
          @endforeach
        </tbody>
      </table>

      {{$province->links()}}
</div>
</div>

</x-layout>
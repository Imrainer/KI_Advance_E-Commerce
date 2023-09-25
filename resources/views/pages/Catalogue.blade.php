<x-layout title="Catalogue | Jelajah Nusantara">
 
    <div class="d-flex">
    <x-Sidebar photo="{{$admin->photo}}" name="{{$admin->name}}"></x-Sidebar>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Catalogue</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>    
          <div class="modal-body">
          
            <form action="http://localhost/laravel_katalogue/public/catalogue/add-catalogue" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Nama</label>
                  <input type="text" class="form-control" name="name">
                </div>
    
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Detail</label>
                  <input type="text" class="form-control" name="detail_content">
                </div>

                <div class="dropdown">
                    <label for="province-select">Province:</label>
                    <select class="form-control" id="province-select" name="province_id">
                        <option value="">Select a province</option>
                        @foreach ($province as $province)
                            <option value="{{ $province->id }}">{{ $province->province }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="dropdown">
                    <label for="city-select">City:</label>
                    <select class="form-control" id="city-select" name="city_id">
                        <option value="">Select a city</option>
                        @foreach ($city as $city)
                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                        @endforeach
                    </select>
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
                    <label for="exampleInputEmail1" class="form-label">Informasi Fasilitas</label>
                    <input type="text" class="form-control" name="facility_information">
                  </div>

                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"> Longitude</label>
                    <input type="text" class="form-control" name="longitude">
                  </div>

                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Latitude </label>
                    <input type="text" class="form-control" name="latitude">
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
        
        <form action="http://localhost/laravel_katalogue/public/catalogue" method="GET" class="col-md-9 mt-3">
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
              $counter = ($catalogue->currentPage() - 1) * $catalogue->perPage() + 1;
                @endphp     
               @foreach ($catalogue as $index => $item)
               <tr>
                <th scope="row">{{ $counter++ }}</th>
                <td>{{$item->name}}</td>
                <td>
                <a href="http://localhost/laravel_katalogue/public/catalogue/{{$item->id}}" class="me-1 text-warning fw-bold text-decoration-none">Open</a>
                <a href="http://localhost/laravel_katalogue/public/catalogue/edit/{{$item->id}}" class="me-1 fas fa-pen text-primary text-decoration-none"></a>
                <a href="http://localhost/laravel_katalogue/public/catalogue/delete/{{$item->id}}" class="ms-1 fas fa-trash text-danger"></a>  
                <td>
              </tr>
              @endforeach
            </tbody>
          </table>
    
          {{$catalogue->links()}}
    </div>
    </div>
    
    </x-layout>
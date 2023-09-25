<x-layout title="Edit Catalogue | Jelajah Nusantara">
   
    <div class="container col-md-5">
      @foreach ( $catalogue as $item)
      <form action="http://localhost/laravel_katalogue/public/catalogue/edit-store/{{$catalogue->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit Catalogue </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Nama</label>
          <input type="text" class="form-control"  value="{{$catalogue->name}}" name="name" id="exampleInputEmail1">
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

      
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Foto Thumbnail</label>
        <input type="file" class="form-control" name="photo_thumbnail"   id="exampleInputEmail1">
      </div>
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>



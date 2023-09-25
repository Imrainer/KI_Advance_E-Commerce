<x-layout title="Edit Carousel | Jelajah Nusantara">
   
    <div class="container col-md-5">
      @foreach ( $carousel as $item)
      <form action="http://localhost/laravel_katalogue/public/carousel/edit-store/{{$carousel->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit carousel </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">carousel</label>
          <input type="file" class="form-control"  value="{{$carousel->photo}}" name="photo" id="exampleInputEmail1">
        </div>

        <div class="dropdown">
          <label for="catalogue-select">Catalogue:</label>
          <select class="form-control" id="catalogue-select" name="catalogue_id">
              <option value="">Select a catalogue</option>
              @foreach ($catalogue as $catalogue)
                  <option value="{{ $catalogue->id }}">{{ $catalogue->name }}</option>
              @endforeach
          </select>
      </div>
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>



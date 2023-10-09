<x-layout title="Edit City | E-Commerce">
   
    <div class="container col-md-5">
      @foreach ( $city as $item)
      <form action="http://localhost/laravel_katalogue/public/city/edit-store/{{$city->id}}" method="POST" enctype="multipart/form-data" class="card p-3 mt-3">
        @csrf @method('put')
        @endforeach
        <h3> Form Edit City </h3>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">City</label>
          <input type="text" class="form-control"  value="{{$city->city}}" name="city" id="exampleInputEmail1">
        </div>

        <div class="dropdown">
            <label for="province-select">Province:</label>
            <select class="form-control" id="province-select" name="province">
                <option value="">Select a province</option>
                @foreach ($province as $province)
                    <option value="{{ $province->id }}">{{ $province->province }}</option>
                @endforeach
            </select>
        </div>
       
        <div class="d-flex justify-content-center ">
        <button type="submit" class="btn btn-outline-primary">Submit</button></div>
      </form>
</div>
</x-layout>



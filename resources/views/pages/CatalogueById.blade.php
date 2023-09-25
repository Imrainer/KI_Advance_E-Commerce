<x-layout title="{{$catalogue->name}} | Jelajah Nusantara">
 
    <div class="d-flex">
    <x-Sidebar photo="{{$admin->photo}}" name="{{$admin->name}}"></x-Sidebar>
    

<div class="kontener ms-4 border shadow-lg col-md-6">

    <img src="{{ asset ('storage/' . $catalogue->photo_thumbnail) }}"  class="container p-1" width="500px" alt="Foto Thumbnail ">

    <div class="content">
        <h5 class="p-3">Details:
        <p class="text-muted">{{$catalogue->detail_content}}</p>
        </h5>

        <h5 class="p-3">Facility Informasi:
            <p class="text-muted" >{{$catalogue->facility_information}}</p>
            </h5>

    </div>


</div>

<div class="content2 border col-md-3 shadow-lg">
    <h5 class="p-3 text-muted"> {{$catalogue->categories->category}}</p>
    <h1 class="p-3 text-primary">{{$catalogue->name}}</h1>
    <p class="p-3">{{$catalogue->city->city}}, {{$catalogue->province->province}}  </p>
      
        <h2 class="p-3">Rp. {{$catalogue->price}}</h2 class="p-3">


</div>

    </x-layout>
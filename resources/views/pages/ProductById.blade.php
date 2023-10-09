<x-layout title="{{$product->name}} | E-Commerce">
 
    <div class="d-flex">
    <x-Sidebar photo="{{$admin->photo}}" name="{{$admin->name}}"></x-Sidebar>
    

<div class="kontener ms-4 border shadow-lg col-md-6">

    <img src="{{ asset ('storage/' . $product->photo_thumbnail) }}"  class="container p-1" width="500px" alt="Foto Thumbnail ">

    <div class="content">
        <h5 class="p-3">Details:
        <p class="text-muted">{{$product->product_description}}</p>
        </h5>

    </div>
</div>

<div class="content2 border col-md-3 shadow-lg">
    <h5 class="p-3 text-muted"> {{$product->categories->category}}</p>
    <h1 class="p-3 text-primary">{{$product->name}}</h1>
        <h2 class="p-3">Rp. {{$product->price}}</h2 class="p-3">
</div>

    </x-layout>
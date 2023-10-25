<x-layout title="Login | E-Commerce">

<style>


.icon{
  color: rgb(63, 197, 146);
}

.title{
  color:  rgb(73, 108, 173);
}

.button {
  background-color:   rgb(80, 73, 173);
  color: white;
  width: 150px;
}

.button:hover{
  background-color: white;
  outline:10px  rgb(73, 108, 173);
  color:   rgb(80, 73, 173);
}

</style>
@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif

@foreach($errors->all() as $msg)
  <div class="alert alert-danger">{{$msg}}</div>
  @endforeach

<div class="container mt-5 col-md-5 shadow-lg bg-white">
      <div class=" col-md-12">
    <form action="http://localhost/laravel_E-Commerce/public/login" class="p-3" method="POST">
        @csrf
        <h1 class="text-primary">E COMMERCE</h1>
            
         <h5 class="fst-roboto mt-3"> Sign in </h5>
        <div class="mb-3 mt-3 col-md-11 form-floating">
          <input type="email" class="form-control" name="email" id="floatingInput" placeholder="Masukkan Email" >
          <label for="floatingInput">Email address</label>
          </div>
       
          <div class="mb-3 mt-3 col-md-11 form-floating">
            <input type="password" class="form-control" name='password' id="floatingInput" placeholder="Masukkan Password" fdprocessedid="cj01lg">
            <label for="floatingInput">Password</label>
            </div>
       
        <div class="d-flex justify-content-center ">
        <button type="submit" class="button btn ">Login</button></div>
      </form>
</div>
</div>
</x-layout>
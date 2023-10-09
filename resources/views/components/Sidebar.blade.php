
<style>
.sidebar {
    height: 100vh;
    background-color:  rgb(255, 255, 255);
}

.hover{
  color: rgb(161, 161, 161);
}

.hover:hover{
  background-color: rgb(117, 117, 117);
  border: 1px solid white;
}

.active{
  background-color: rgb(228, 228, 228);
  border: 1px solid rgb(0, 0, 0) ;
  color:  rgb(255, 255, 255);
}

.button {
    border: none;
}

.title {
  color: rgb(73, 108, 173);
}

.text {
  color:rgb(255, 255, 255);
}

.content {
    height: 70vh;
}

.profil[title] {
  position: relative;
  cursor: pointer;
}

.profil[title]:hover:after {
  content: attr(title);
  padding: 5px;
  color: #000000;
  background-color: #000;
  position: absolute;
  z-index: 999;
  left: 50%;
  transform: translateX(-50%);
}

</style>

<div class="sidebar col-md-2 shadow-lg">
<div class="ms-2">
 
  <h3 class="mt-5 ms-3 text-primary fw-bold">E COMMERCE</h3>
    
  </div>

    <div class="content pt-3 ">
<div class="hover {{ Request::is('dashboard') ? 'active' : '' }}">
<a href="http://localhost/laravel_E-Commerce/public/dashboard" class="text-decoration-none"> <h6 class=" ms-4 py-2 text-dark"><i class="fas fa-book me-2"></i> Dashboard</h6></a></div>
<div class="hover {{ Request::is('monitoring') ? 'active' : '' }}">
<a href="http://localhost/laravel_E-Commerce/public/monitoring" class="text-decoration-none"><h6 class=" ms-4 py-2 text-dark "><i class="fas fa-chart-line me-2"></i> Monitoring</h6></a></div>
<div class="hover {{ Request::is('admin') ? 'active' : '' }}">
<a href="http://localhost/laravel_E-Commerce/public/admin" class="text-decoration-none"><h6 class=" ms-4 py-2 text-dark "><i class="fas fa-users me-2"></i> Admin</h6></a></div>
<div class="hover {{ Request::is('product') ? 'active' : '' }}">
  <a href="http://localhost/laravel_E-Commerce/public/product" class="text-decoration-none"><h6 class=" ms-4 py-2 text-dark "><i class="fas fa-landmark me-2"></i> Product</h6></a></div>
<div class="hover {{ Request::is('carousel') ? 'active' : '' }}">
  <a href="http://localhost/laravel_E-Commerce/public/carousel" class="text-decoration-none"><h6 class=" ms-4 py-2 text-dark "><i class="fas fa-city me-2"></i>Carousel</h6></a></div>
<div class="hover {{ Request::is('category') ? 'active' : '' }}">
  <a href="http://localhost/laravel_E-Commerce/public/category" class="text-decoration-none"><h6 class=" ms-4 py-2 text-dark "><i class="fas fa-building me-2"></i> Category</h6></a></div>
  </div>

<div class=" ms-5 mt-2 d-flex">
    @if (empty(($photo)))
    <a><img src="{{ asset('storage/blank_user.png')}}" data-bs-toggle="modal" data-bs-target="#modalfotoblank" alt="Profile Picture" width="40px" class="profil rounded-circle"></a>
@else
<a><img src="{{ asset('storage/'.$photo) }}"  data-bs-toggle="modal" data-bs-target="#modalfoto" alt="Profile Picture" width="40px" class="profil rounded-circle"></a>
    @endif

    <div class="modal fade" id="modalfotoblank" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-circle">
        <div class="modal-content rounded-circle">
      <img src="{{ asset('storage/blank_user.png') }}" class="rounded-circle">
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalfoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog rounded-circle">
        <div class="modal-content rounded-circle">
          <img src="{{ asset('storage/'.$photo) }}" class="rounded-circle">
        </div>
      </div>
    </div>

  <div class="dropdown mt-1">
    <p class="ms-2 text-dark dropdown-toggle fst-italic" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      {{$name}} 
    </p>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item" href="http://localhost/laravel_E-Commerce/public/profile/admin">Edit Profile</a></li>
    <li><a href="http://localhost/laravel_E-Commerce/public/logout" class="dropdown-item text-decoration-none"><h6 class=" fst-italic fwt-light pt-2 ">Logout </h6></a></li>
  </ul>
</div>
</div>
</div>

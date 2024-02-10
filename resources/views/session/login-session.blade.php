@extends('layouts.user_type.guest')

@section('content')
  <main class="main-content mt-0 vh-100" style="background-image: url(../assets/img/bgLogin.png); background-size: cover; background-position: center; ">
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="card m-auto mt-8 p-5" style="width: 40%">
                    <div class="card-body">
                        <h3 class="card-title text-dark">SIGN TO YOUR ACCOUNT</h3>
                        <form role="form" method="POST" action="/session">
                            @csrf
                            <div class="wave-group my-4">
                                <i class="fas fa-envelope"></i> <!-- Icon -->
                                <input required="" type="email" class="input" name="email" id="email">
                                @error('email')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                                <span class="bar"></span>
                                <label class="label">
                                    <span class="label-char" style="--index: 0">E</span>
                                    <span class="label-char" style="--index: 1">m</span>
                                    <span class="label-char" style="--index: 2">a</span>
                                    <span class="label-char" style="--index: 3">i</span>
                                    <span class="label-char" style="--index: 4">l</span>
                                </label>
                            </div>
    
                            <div class="wave-group my-4">
                                <i class="fas fa-lock"></i> <!-- Icon -->
                                <input required="" type="password" class="input" name="password" id="password">
                                @error('password')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                                <span class="bar"></span>
                                <label class="label">
                                    <span class="label-char" style="--index: 0">P</span>
                                    <span class="label-char" style="--index: 1">a</span>
                                    <span class="label-char" style="--index: 2">s</span>
                                    <span class="label-char" style="--index: 3">s</span>
                                    <span class="label-char" style="--index: 4">w</span>
                                    <span class="label-char" style="--index: 5">o</span>
                                    <span class="label-char" style="--index: 6">r</span>
                                    <span class="label-char" style="--index: 7">d</span>
                                </label>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn w-100 mt-4 mb-0 text-light" style="background-color: #CE3534; font-weight: bolder">L o g i n</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
    </section>
  </main>
@endsection

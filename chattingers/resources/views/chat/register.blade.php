@extends('layouts.index')

@section('user-list')
    
<div class="container p-5" style="width:700px;">
<!-- Default form login -->
<form method="POST" class="text-center border border-light p-5" action="{{route('demoSendRegister')}}">

        <p class="h4 mb-4">Sign up</p>
    
        <!-- Email -->
        <input type="text" name="name" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="username">
        <input type="email" name="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">
        <input type="number" name="telp" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="No. telp">
    
        <!-- Password -->
        <input type="password" name="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password">
    
        <div class="d-flex justify-content-around">
            <div>
                <!-- Remember me -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                    <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
                </div>
            </div>
            <div>
                <!-- Forgot password -->
                <a href="">Forgot password?</a>
            </div>
        </div>
    
        <!-- Sign in button -->
        <button class="btn btn-primary btn-block my-4" type="submit">Register</button>
    
        <!-- Register -->
        <p>Not a member?
            <a href="">Register</a>
        </p>
    
        <!-- Social login -->
        <p>or sign in with:</p>
    
        <a href="#" class="mx-2" role="button"><i class="fab fa-facebook-f light-blue-text"></i></a>
        <a href="#" class="mx-2" role="button"><i class="fab fa-twitter light-blue-text"></i></a>
        <a href="#" class="mx-2" role="button"><i class="fab fa-linkedin-in light-blue-text"></i></a>
        <a href="#" class="mx-2" role="button"><i class="fab fa-github light-blue-text"></i></a>
    
    </form>
</div>
    <!-- Default form login -->
    @endsection
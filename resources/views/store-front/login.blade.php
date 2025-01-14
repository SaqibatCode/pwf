@extends('store-front.layout.layout')

@section('main-content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-4xl font-extralight mb-6 text-center text-gray-800">Login</h2>

    <form action="/login" method="POST">
        @csrf
      <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
        <input type="email" name="email" id="email"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
               placeholder="Your email address" required>
        @error('email')
          <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
        <input type="password" name="password" id="password"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
               placeholder="Your password" required>
        @error('password')
          <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between mb-4">
          <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="mr-2" >
            <label for="remember" class="text-gray-700 text-sm font-semibold">Remember Me</label>
          </div>
          <a href="/forgot-password" class="text-blue-500 hover:underline text-sm font-semibold">Forgot Password?</a>
      </div>


      <button type="submit"
              class="rounded-full border-2 border-[#FCCDC5] py-2 px-4 uppercase text-xs lg:text-sm font-bold tracking-[1.05px]">
        Login
      </button>

    <div class="mt-4 text-center">
        <p class="text-sm font-semibold">Don't have an account? <a href="/register" class="text-blue-500 hover:underline font-semibold">Register</a></p>
    </div>
    </form>
  </div>
</div>
@endsection

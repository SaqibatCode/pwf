@extends('store-front.layout.layout')

@section('main-content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 font-poppins">
  <div class="w-full max-w-xl space-y-8 bg-white p-8 rounded-lg shadow-lg border border-gray-200">
    <div class="text-center">
      <h2 class="text-3xl font-bold text-gray-900">Login</h2>
      <p class="mt-2 text-sm text-gray-600">Welcome back! Please sign in to your account.</p>
    </div>

    <form action="/login" method="POST" class="space-y-6">
      @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email"
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
               placeholder="Your email address" required>
        @error('email')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password"
               class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
               placeholder="Your password" required>
        @error('password')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
          <label for="remember" class="ml-2 block text-sm text-gray-700">Remember Me</label>
        </div>
        <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
      </div>

      <button type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
        Login
      </button>

      <div class="text-center">
        <p class="text-sm text-gray-600">
          Don't have an account? <a href="/register" class="text-blue-600 hover:underline">Register</a>
        </p>
      </div>
    </form>
  </div>
</div>
@endsection

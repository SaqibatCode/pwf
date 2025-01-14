@extends('store-front.layout.layout')

@section('main-content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-lg">
            <h2 class="text-4xl font-extralight mb-6 text-center text-gray-800">Register</h2>

            <form action="{{ route('buyer.register.post') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 text-sm font-semibold mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Your first name" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 text-sm font-semibold mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Your last name" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label for="father_name" class="block text-gray-700 text-sm font-semibold mb-2">Father's Name</label>
                    <input type="text" name="father_name" id="father_name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your father's name" required>
                    @error('father_name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your email address" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="dob" class="block text-gray-700 text-sm font-semibold mb-2">Date of Birth</label>
                    <input type="date" name="dob" id="dob"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                    @error('dob')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="city" class="block text-gray-700 text-sm font-semibold mb-2">City</label>
                    <input type="text" name="city" id="city"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your city" required>
                    @error('city')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-semibold mb-2">Phone Number</label>
                    <input type="tel" name="phone" id="phone"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your phone number" required>
                    @error('phone')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-semibold mb-2">Address</label>
                    <input type="text" name="address" id="address"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your Address" required>
                    @error('address')
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

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" class="mr-2" required>
                        <label for="terms" class="text-gray-700 text-sm font-semibold">I agree to the <a href="/terms"
                                class="text-blue-500 hover:underline font-semibold">Terms and Conditions</a></label>

                    </div>
                    @error('terms')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="rounded-full border-2 border-[#FCCDC5] py-2 px-4 uppercase text-xs lg:text-sm font-bold tracking-[1.05px]">
                    Register
                </button>

                <div class="mt-4 text-center">
                    <p class="text-sm font-semibold">Already have an account? <a href="/login"
                            class="text-blue-500 hover:underline font-semibold">Login</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

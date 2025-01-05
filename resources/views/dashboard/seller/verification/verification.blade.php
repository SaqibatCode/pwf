@extends('dashboard.layout.layout')
@section('pageTitle')
    Seller Verification
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Verification</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Verfication</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <!-- Include Bootstrap CSS (e.g., in your layout) -->




            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            @if (Auth::user()->verification == 'Unverified')
                                <form action="{{ route('verifications.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Seller Type -->
                                    <div class="mb-3">
                                        <label for="seller_type" class="form-label">Seller Type</label>
                                        <select name="seller_type" id="seller_type" class="form-control">
                                            <option value="">Select Seller Type</option>
                                            <option value="Individual">Individual</option>
                                            <option value="Shop Keeper">Shop Keeper</option>
                                        </select>
                                        @error('seller_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- CNIC Front Picture -->
                                    <div class="mb-3">
                                        <label for="cnic_front_picture" class="form-label">CNIC Front Picture</label>
                                        <input type="file" name="cnic_front_picture" id="cnic_front_picture"
                                            accept="image/*" class="form-control">
                                        @error('cnic_front_picture')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- CNIC Back Picture -->
                                    <div class="mb-3">
                                        <label for="cnic_back_picture" class="form-label">CNIC Back Picture</label>
                                        <input type="file" name="cnic_back_picture" id="cnic_back_picture"
                                            accept="image/*" class="form-control">
                                        @error('cnic_back_picture')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- CNIC Holding Selfie -->
                                    <div class="mb-3">
                                        <label for="cnic_holding_selfie" class="form-label">Selfie Holding CNIC</label>
                                        <input type="file" name="cnic_holding_selfie" id="cnic_holding_selfie"
                                            accept="image/*" class="form-control">
                                        @error('cnic_holding_selfie')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- ShopKeeper Fields (Initially Hidden) -->
                                    <div class="shopKeeper d-none">
                                        <div class="mb-3">
                                            <label for="shop_name" class="form-label">Shop Name</label>
                                            <input type="text" name="shop_name" id="shop_name"
                                                value="{{ old('shop_name') }}" class="form-control">
                                            @error('shop_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="shop_picture" class="form-label">Shop Picture</label>
                                            <input type="file" name="shop_picture" id="shop_picture" accept="image/*"
                                                class="form-control">
                                            @error('shop_picture')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="shop_business_card_picture" class="form-label">Shop Business Card
                                                Picture</label>
                                            <input type="file" name="shop_business_card_picture"
                                                id="shop_business_card_picture" accept="image/*" class="form-control">
                                            @error('shop_business_card_picture')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="shop_address" class="form-label">Shop Address</label>
                                            <input type="text" name="shop_address" id="shop_address"
                                                value="{{ old('shop_address') }}" class="form-control">
                                            @error('shop_address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Rep Post Link -->
                                    <div class="mb-3">
                                        <label for="rep_post_link" class="form-label">Rep Post Link</label>
                                        <input type="url" name="rep_post_link" id="rep_post_link"
                                            value="{{ old('rep_post_link') }}" class="form-control">
                                        @error('rep_post_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            @elseif(Auth::user()->verification == 'Pending')
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        <ul>
                                            <li>{{ session('success') }}</li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="alert alert-warning" role="alert">
                                    Your Verification Request Has Been Sent and Its Pending Approval From Playware. Please
                                    Be Patient.
                                </div>
                            @elseif(Auth::user()->verification == 'Verified' || Auth::user()->verification == 'Verified Plus')
                              <script>
                                    window.location.href = '/portal';
                              </script>
                            @endif


                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque tenetur, officiis, labore, laboriosam
                        id rem unde laudantium autem magni exercitationem at! Molestias, reprehenderit culpa! Aut inventore
                        exercitationem ab placeat quaerat at ex accusantium mollitia dolores voluptatibus iure soluta
                        blanditiis esse, in natus tempora! Quam amet veritatis et, quasi assumenda nulla quod, animi ipsum
                        commodi saepe, dicta molestias! Reprehenderit sequi veniam expedita, esse id facere ipsa nisi rerum
                        natus dignissimos asperiores amet, praesentium dicta, iusto eos. Laudantium sint recusandae quia
                        voluptas sunt repudiandae debitis ab tempora facilis eius, mollitia animi dolorum fuga dolorem ea
                        iste porro! Iure voluptate voluptatum aspernatur voluptates fuga ullam commodi non harum repellendus
                        similique blanditiis rerum libero reprehenderit unde, esse recusandae ad sit. Doloribus quia soluta
                        delectus dolores culpa debitis repellat architecto at hic aliquid ratione accusamus quasi
                        reiciendis, ad quo excepturi officia iusto iure. Ipsam adipisci repellendus hic, quidem fuga
                        accusantium necessitatibus totam magni similique blanditiis! Praesentium excepturi explicabo
                        accusantium tenetur temporibus maiores corrupti earum ex fugit obcaecati ullam dolorem corporis,
                        sunt eaque, rerum quam. Sed voluptate eveniet perferendis nostrum aspernatur! Quas, excepturi ut
                        iusto ab repudiandae, aspernatur odio expedita suscipit corporis fuga soluta? Possimus dolore fugiat
                        quam quae, culpa accusamus eligendi. Architecto earum ipsa ad?</p>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('additionScript')
    <script>
        $(document).ready(function() {
            function updateVerificationForm() {
                if ($('#seller_type').val() === 'Shop Keeper') { // Check if 'Shop Keeper' is selected
                    $('.shopKeeper').removeClass('d-none'); // Show the shopKeeper div
                } else {
                    $('.shopKeeper').addClass('d-none'); // Hide the shopKeeper div
                }
            }

            $('#seller_type').on('change', updateVerificationForm); // Pass the function reference
            updateVerificationForm(); // Initialize the form on page load
        });
    </script>
@endsection

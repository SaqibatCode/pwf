<form action="{{ route('checkout.placeOrder') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <h3>Vendor: {{ $vendorProducts->first()->vendor->name }}</h3>

    @foreach ($vendorProducts as $product)
        <div class="product">
            <img src="{{ $product->getFirstImageUrl() }}" alt="{{ $product->name }}">
            <span>{{ $product->name }} ({{ $product->quantity }} x {{ $product->price }})</span>
        </div>
    @endforeach

    <!-- Payment Method Selection -->
    <label for="payment_method">Choose Payment Method:</label>
    <select name="payment_method" id="payment_method" required>
        <option value="cod">Cash on Delivery</option>
        <option value="bank_transfer">Bank Transfer</option>
    </select>

    <!-- Payment Screenshot (visible if Bank Transfer selected) -->
    <div id="payment_screenshot_div" style="display:none;">
        <label for="payment_screenshot">Upload Payment Screenshot:</label>
        <input type="file" name="payment_screenshot" id="payment_screenshot">
    </div>

    <button type="submit">Place Order</button>
</form>

<script>
    // Show/hide payment screenshot input based on payment method selection
    document.getElementById('payment_method').addEventListener('change', function() {
        const paymentMethod = this.value;
        if (paymentMethod === 'bank_transfer') {
            document.getElementById('payment_screenshot_div').style.display = 'block';
        } else {
            document.getElementById('payment_screenshot_div').style.display = 'none';
        }
    });
</script>

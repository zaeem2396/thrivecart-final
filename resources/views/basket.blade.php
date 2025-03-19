<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Basket</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="container mt-4">
    <h1 class="mb-4">Shopping Basket</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Products</h2>
            <ul class="list-group">
                @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $product->name }} ({{ $product->code }}) - ${{ number_format($product->price, 2) }}
                    <button class="btn btn-primary btn-sm" onclick="addToBasket('{{ $product->code }}')">Add</button>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6">
            <h2>Basket</h2>
            <ul class="list-group" id="basket_items"></ul>
            <h3 class="mt-3">Total: $<span id="total">0.00</span></h3>
        </div>
    </div>

    <script>
        let basket = [];

        function addToBasket(code) {
            let itemIndex = basket.findIndex(item => item.code === code);
            if (itemIndex > -1) {
                basket[itemIndex].quantity++;
            } else {
                basket.push({
                    code: code,
                    quantity: 1
                });
            }
            updateBasketUI();
            calculateTotal();
        }

        function updateBasketUI() {
            let basketList = document.getElementById('basket_items');
            basketList.innerHTML = "";

            basket.forEach(item => {
                let newItem = document.createElement("li");
                newItem.className = "list-group-item";
                newItem.textContent = `${item.code} - Qty: ${item.quantity}`;
                basketList.appendChild(newItem);
            });
        }

        const calculateTotal = async () => {
            try {
                const response = await axios.post('{{ route("calculate.total") }}', {
                    basket: basket
                }, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.data.success) {
                    document.getElementById('total').textContent = response.data.total;
                } else {
                    alert(`Error: ${response.data.message}`);
                }
            } catch (error) {
                console.error(`Error calculating total: ${error}`);
            }
        }
    </script>

</body>

</html>
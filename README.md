# 🛒 Laravel Basket Service
A simple Laravel service for adding products to a shopping basket, applying discounts, and calculating total prices with dynamic delivery charges.

---

## 📌 Features
✅ **Add products to basket** by product code.  
✅ **Apply a discount on Red Widgets (R01) - "Buy One, Get 2nd Half Price".**  
✅ **Calculate delivery charges dynamically.**  
✅ **Store configurable settings in the database (`app_settings` table).**  
✅ **Use Pest for unit testing.**  

---

## 📌 How It Works

### **1️⃣ Adding Products to Basket**
Products are stored in the **`products`** table with the following fields:

| Code  | Name          | Price  |
|-------|--------------|--------|
| B01   | Blue Widget  | $7.95  |
| G01   | Green Widget | $24.95 |
| R01   | Red Widget   | $32.95 |

To add a product to the basket, use:
```php
$basketService = new BasketService(new DefaultPricingStrategy());
$item = $basketService->addToBasket('B01');
```
This will return
```
[
    'code' => 'B01',
    'quantity' => 1
]
```
## Calculating total
Use the getTotal() method to calculate the total price:
```
$basketItems = [
    ['code' => 'B01', 'quantity' => 1],
    ['code' => 'G01', 'quantity' => 1],
];

$total = $basketService->getTotal($basketItems);
echo $total; // 37.85
```
## Discounts & Delivery Charges
Discounts
<li>Red Widget (R01) Discount: "Buy One, Get 2nd Half Price".</li>
```
$basketItems = [
    ['code' => 'R01', 'quantity' => 2]
];

$total = $basketService->getTotal($basketItems);
echo $total; // 54.37 (Second R01 is half price)


| Total price  | Delivery charge
|-------|-----------------------|
| > $50   | $4.95           |
| > $90   | $2.95          |
| >= $90   | FREE            |

## Steps to run this project
### 📌 Environment Variables

| Key           | Value    |
|--------------|---------|
| `DB_CONNECTION` | `mysql` |
| `DB_HOST`       | `mysql` |
| `DB_PORT`       | `3306`  |
| `DB_DATABASE`   | `acme`  |
| `DB_USERNAME`   | `root`  |
| `DB_PASSWORD`   | `root`  |
```
<li>Copy the below credentials in .env file</li>
<li>Clone this repo</li>
<li>Run docker compose up --build</li>
<li>Run docker compose exec app bash to open terminal inside docker container</li>
<li>Run php artisan migrate</li>
<li>Run php artisan db:seed --class=ProductSeeder</li>
<li>Run php artisan db:seed --class=AppSettingSeeder</li>
<li>The above two commands will populate the table</li>
<li>Hit the url http://localhost:8000</li>
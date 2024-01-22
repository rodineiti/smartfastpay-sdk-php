# Smartfastpay SDK for PHP

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/php-%5E8.1-blueviolet.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

Welcome to the initial release of the **Smartfastpay SDK** for PHP - a powerful and flexible library for processing payments and payouts.

## Key Features:

1. **Payments and Payouts Implementation:** Full support for processing payments and payouts.

2. **Design Patterns and Best Practices:** Utilizes design patterns like Strategy, following best practices for clean and maintainable code.

3. **Flexible Configurations:** Easily configure client keys and secrets.

4. **Guzzle HTTP Requests:** Integrates with Guzzle HTTP for efficient and reliable requests.

5. **Exception Handling:** Implements specific exceptions for each resource, along with the use of HTTP exceptions for error handling.

6. **Secure Authentication:** Implements secure authentication with automatic access token renewal.

## Getting Started:

1. **Installation via Composer:**

   ```bash
   composer require rodineiti/smartfastpay-sdk-php
   ```

2. **Quick Setup:**

   ```php
   use Rodineiti\SmartfastpaySdk\Config\Config;
   use Rodineiti\SmartfastpaySdk\Payment;
   use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixPaymentStrategy;

   $config = new Config('client_id', 'client_secret');

   $payment = new Payment($config);
   $payment->setStrategy(new PixPaymentStrategy());
   ```

3. **Payment Processing:**

   ```php
    use Rodineiti\SmartfastpaySdk\Strategy\Payment\Pix\PixParams;

    try {
        $respose = $payment->processPayment(new PixParams(
            uniqid(),
            'John Doe',
            'john.doe@example.com',
            '12345678909',
            2.00,
            'BRL',
            'http://example.com/callback',
            uniqid(),
        ));

        header("Content-Type: application/json");
        echo $respose;
    } catch (Exception $e) {
        var_dump("Error on create payment: {$e->getMessage()}");
    }
   ```

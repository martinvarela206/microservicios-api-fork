<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Customer;

$clientes = [
    [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'jdoe@hotmail.com',
    ],
    [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jsmith@hotmail.com',
    ],
];

foreach ($clientes as $infoCliente) {
    $email = $infoCliente['email'];
    Customer::updateOrCreate(
        ['email' => $email], // Condición de búsqueda
        $infoCliente
    );
}

$listado = Customer::all();
foreach ($listado as $customer) {
    echo "{$customer->id}. {$customer->first_name}, {$customer->last_name} - {$customer->email}\n";
}

echo "\n\nTotal customers: " . $listado->count() . "\n";
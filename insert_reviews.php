<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Review;
use App\Models\Product;
use App\Models\Customer;

echo "1. Creando Reseñas\n";

echo "\n1.1. Productos\n";
$iPhone = Product::where('name', 'like', '%iPhone%')->first();
$samsung = Product::where('name', 'like', '%Samsung%')->first();

echo $iPhone . "\n";
echo $samsung . "\n";

echo "\n1.2. Clientes\n";

$john = Customer::where('email', 'jdoe@hotmail.com')->first();
$martin = Customer::where('email', 'mvarelochoa@hotmail.com')->first();

echo $john . "\n";
echo $martin . "\n";

echo "\n1.3. Reseñas\n";
// Forma estándar: crear instancia, asignar relaciones y guardar
$reseña = Review::firstWhere([
    'product_id' => $iPhone->id,
    'customer_id' => $john->id
]);
if ($reseña) {
    $reseña->delete(); // Elimina si ya existe para evitar duplicados en este
}

$reseña = new Review([
    'rating' => 5,
    'comment' => 'Excelente producto, muy satisfecho con la compra.'
]);
$reseña->product()->associate($iPhone);
$reseña->customer()->associate($john);
$reseña->save();
echo "$reseña\n";

// Forma alternativa 1: usando create() con IDs
$reseña->delete();
$reseña = Review::create([
    'rating' => 4,
    'comment' => 'Buen producto, lo recomiendo.',
    'product_id' => $iPhone->id,
    'customer_id' => $john->id
]);
echo "$reseña\n";

// Forma alternativa 2: usando create() con relaciones
// $reseña->delete();
$reseña = $iPhone->reviews()->updateOrCreate(
    [
        'customer_id' => $john->id,
        'product_id' => $iPhone->id
    ],
    [
        'rating' => 3,
        'comment' => 'El producto está bien, pero esperaba más.',
        'customer_id' => $john->id
    ]
);

$iPhone->reviews()->updateOrCreate(
    [
        'customer_id' => $martin->id
    ],
    [
        'rating' => 2,
        'comment' => 'No estoy satisfecho con el producto.'
    ]
);


echo "\n2. Consultando Reseñas\n";
// Obtener todas las reseñas de un producto
$reseñasIphone = $iPhone->reviews;
echo "Reseñas para {$iPhone->name}:\n";
foreach ($reseñasIphone as $r) {
    echo "- $r\n";
}

echo "Promedio de calificaciones para {$iPhone->name}: " . $iPhone->averageRating() . "\n";
<?php
$page_name = "invoice";
include_once __DIR__ . '/inc/header.php';
include_once __DIR__ . '/classes/cartItemClass.php';

$invoice_num = 123;
$invoice_date = date('Y-m-d');
$author = 'LAP Produts Ltd.';
$invoice_header = '
LAP Procuts Ltd
Mike Mars
www.lap-products.com
';

$invoice_recipient = '
Jon Doe
Musterstrasse 3
1234 Musterstadt
';

$invoice_footer = 'Please settle the invoice within 14 days.
<b>Recipient: </b> LAP Procuts Ltd
<b>IBAN: </b> AT20 0815 9999 8888 7777
<b>BIC: </b>STSPAT2G';

$items = new cartItem();
$invoice_items = $items->getOrderItems(11);


$price_total = 0;
$grandTotal = 0;
foreach ($invoice_items as $invoice_item) {
    $quantity = $invoice_item['quantity'];
    $pricePU = $invoice_item['price'];
    $price_total = $quantity * $pricePU;
    $grandTotal += $price_total;
}

$recipient = "customer@email.com";
$subject = "Your invoice";
$from = "support@lapproducts.com";
$text = var_dump($invoice_items);

mail($recipient, $subject, $text, $from);



?>



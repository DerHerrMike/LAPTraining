<?php
include_once __DIR__ . '/classes/cartItemClass.php';

$invoice_num = 123;
$invoice_date = date('Y-m-d');
$pdfAuthor = 'LAP Procuts Ltd.';
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
//$invoice_items = array($order_items);

$vat = 0.0;

$pdfName = 'Invoice_' . $invoice_num . '.pdf';


/** @noinspection HtmlDeprecatedAttribute */
$html = '
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
 <tr>
 <td>' . nl2br(trim($invoice_header)) . '</td>
    <td style="text-align: right">
Rechnungsnummer ' . $invoice_num . '<br>
Rechnungsdatum: ' . $invoice_date . '<br>
Lieferdatum: ' . $invoice_date . '<br>
 </td>
 </tr>
 
 <tr>
 <td style="font-size:1.3em; font-weight: bold;">
<br><br>
INVOICE
<br>
 </td>
 </tr>
 
 
 <tr>
 <td colspan="2">' . nl2br(trim($invoice_recipient)) . '</td>
 </tr>
</table>
<br><br><br>
 
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
 <tr style="background-color: #cccccc; padding:5px;">
 <td style="padding:5px;"><b>Name</b></td>
 <td style="text-align: center;"><b>Quantity</b></td>
 <td style="text-align: center;"><b>Price per unit</b></td>
 <td style="text-align: center;"><b>Total</b></td>
 </tr>';

$price_total = 0;
$grandTotal = 0;
foreach ($invoice_items as $invoice_item) {
    $quantity = $invoice_item['quantity'];
    $pricePU = $invoice_item['price'];
    $price_total = $quantity * $pricePU;

}
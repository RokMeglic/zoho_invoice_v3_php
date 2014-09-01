<?php
$invoiceData = array();

/*
c_users_invoices_created = date
storitev = name of invoce item - for example: "USB dongle":)
s_prices_price = price without tax
c_users_invoices_amount = full amount (with tax)

user_data => array (
    c_users_name => name
    c_users_lastname => lastname
    c_users_email => email
    c_users_invoices_street => street
    c_users_fullphone => phone

    c_users_invoices_post => array
     0 => city
     1 => zip

    c_users_invoices_company => 0/1 (is company)
    c_users_invoices_company_name => company name
    c_users_invoices_company_street => company street
    c_countries_foreignname => full country name
);
*/
require_once 'ZohoInvoiceV3.php';
$zohoInvoice = new ZohoInvoiceV3($invoiceData);

try {
    // RM: Get or create contact
    $contactId = $zohoInvoice->getContactIdOrCreateContact();

    // RM: Create invoice
    $invoiceId = $zohoInvoice->createInvoice($contactId);

    // RM: Mark an invoice as sent
    $zohoInvoice->markInvoiceAsSent($invoiceId);

    // RM: Pay invoice
    $zohoInvoice->payInvoice($invoiceId, $contactId);

    // RM: Get HTML of invoice
    $invoiceLink = $zohoInvoice->getInvoice($invoiceId);

    $response = "<a target='_blank' href='{$invoiceLink}'>Click here to view invoice</a>";
} catch (Exception $e) {
    $response = 'There was an error while generating invoice: ' . $e->getMessage();
}
?>
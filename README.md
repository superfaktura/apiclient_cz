## Přehled
SF API umožňuje propojení externích aplikací se SuperFakturou a dovoluje tak vzdáleně vytvářet faktury a získavat údaje o nich. Umožňuje také posílat faktury emailem nebo poštou.

## Quickstart
Abyste se nemuseli trápit s přímým voláním API funkcí a způsobem přenosu dat, připravili jsme pro Vás jednoduchého API klienta, díky kterému můžete Vaše faktury vystavovat nadálku s minimálním úsilím.

Pokud si však chcete vytvořit vlastního API klienta, máme i [obecnou dokumentaci](https://github.com/superfaktura/docs). 

## Postup jak získat PHP-API klienta

### 1. způsob (vyžaduje nainstalovaný systém Git)
1. vytvořte si adresář, který má obsahovat SuperFaktura PHP-API např. (*$> Mkdir / var / www / myproject / libs*)
2. přepněte se do nově vytvořeného adresáře a spusťte přes konzoli příkaz *$> git clone https://github.com/superfaktura/apiclient.git*

### 2. způsob (nevyžaduje nainstalovaný systém Git)
1. Stáhněte si SuperFaktúra PHP-API kliknutím na tlačítko "Stáhnout ZIP", které se nachází na github stránce našeho API.

## Ukázky kódu

Abychom vám usnadnili práci při implementaci našeho API, vytvořili jsme ukázky kódu ([sample.php](https://github.com/superfaktura/apiclient/blob/master/examples/sample.php) a [sample2.php](https://github.com/superfaktura/apiclient/blob/master/examples/sample2.php)), které demonstrují jeho funkcionalitu a dpĺňajú naši dokumentaci o fungující příklady.

## Začínáme používat SuperFaktura PHP-API
Na to, abyste mohli začít API na plno využívat, je třeba:

### 1. Zaregistrovat se v SuperFakture
* Na stránce https://moje.superfaktura.cz/registracia proveďte registraci. Automaticky získáte 30 dní zdarma.
* Po přihlášení vystavte zkušební fakturu přes GUI SuperFaktury

### 2. Udělat základní nastavení v kódu
* Vytvořit novou instance třídy *SFAPIclientCZ*
* Poskytnout v konstruktoru přihlašovací údaje do API
+ **Email** - přihlašovací email do SuperFaktúry
+ **Token** - API token, který najdete v SuperFaktúre po přihlášení do svého účtu "*Nástroje> API přístup*"
```php
require_once('SFAPIclient/SFAPIclient.php');  // inc. SuperFaktúra PHP-API
$login_email = 'login@example.com';  // moje.superfaktura.cz login email
$api_token = 'abcd1234';  // token from my account
$sf_api = new SFAPIclientCZ($login_email, $api_token);  // create SF PHP-API object
```
### 3. Používání PHP-API volání
Níže je uveden seznam všech možných volání, které obsahuje nejnovější verze našeho API. *Všechny PHP funkce našeho API jsou veřejné členské funkce třídy SFAPIclient*. 
Příklad vystavení jednoduché faktury (pokračování předch. příkladu)
```php
// set client for new invoice
$sf_api->setClient(array(
'name' => 'MyClient',
'address' => 'MyClient address 1',
'zip' => 12345,
'city' => 'MyClientCity'
));
// set invoice attributes
$sf_api->setInvoice(array(
'name' => 'MyInvoice'
));
// add new invoice item
$sf_api->addItem(array(
'name' => 'MyInvoiceItem',
'description' => 'Inv. item no. 1',
'unit_price' => 10,
'tax' => 20
));
// save invoice in SuperFaktura
$json_response = $sf_api->save();
// TODO: handle exceptions
```

## Seznam volání (veřejných členských funkcí včetně konstruktoru třídy SFAPIclientCZ)
* *__construct($email, $apikey, $apptitle = '', $module = 'API', $company_id = '')*
* *addItem($item = array())* 
* *addStockItem($item = array())* 
* *addStockMovement($item = array())* 
* *addTags($tag_ids = array())* 
* *clients($params = array(), $list_info = true)* 
* *delete($id)* 
* *deleteInvoiceItem($invoice_id, $id)* 
* *deleteExpense($id)* 
* *deleteStockItem($id)* 
* *edit()* 
* *expense()* 
* *expenses()* 
* *getCountries()* 
* *getSequences()* 
* *getPDF($invoice_id, $token, $language = 'slo')* 
* *getTags()* 
* *invoice($id)* 
* *invoices($params = array(), $list_info = true)* 
* *markAsSent($invoice_id, $email, $subject = '', $message = '')* 
* *payInvoice($invoice_id, $amount, $currency = 'EUR', $date = null, $payment_type = 'transfer')* 
* *payExpense($expense_id, $amount, $currency = 'EUR', $date = null, $payment_type = 'transfer')* 
* *save()* 
* *setClient($key, $value = '')* 
* *setExpense($key, $value = '')* 
* *setInvoice($key, $value = '')* 
* *sendInvoiceEmail($options = array())* 
* *sendInvoicePost($options = array())* 
* *stockItemEdit($item = array())* 
* *stockItems($params = array(), $list_info = true)* 
* *stockItem($id)* 
* *addContactPerson($data)*
* *getExpenseCategories()*
* *setInvoiceSettings($settings)*
* *setInvoiceExtras($extras)*
* *cashRegister($cash_register_id)*
* *sendSMS($data)*
* *setMyData($key, $value = '')*
* *getInvoiceDetails($ids = '')*
* *getUserCompaniesData($getAllCompanies = false)*
* *createRegularFromProforma($proforma_id)*
* *setEstimateStatus($estimate_id, $status)*
* *getBankAccounts()*
* *addBankAccount(array $data)*
* *updateBankAccount(int $id, array $data)*
* *deleteBankAccount(int $id)*
* *addTag(array $data)*
* *updateTag(int $id, array $data)*
* *deleteTag(int $id)*

### 1. __construct
Konstruktor. Nastaví email a API token pro autorizaci.
#### Parametry:
* **$email** *string* povinný 
* **$token** *string* povinný 
* **$apptitle** string nepovinný, název aplikace
* **$module** string nepovinný, název modulu 
* **$company_id** integer nepovinný, ID společnosti, se kterou přes API pracujete (v případě, že máte jen jednu společnosti nemusíte uvádět)

### 2. addItem
Přidá položku na fakturu.
#### Parametry:
* **$item** *pole* povinné
 * **$item_type** string typ položky. Možné hodnoty Invoice(default) a Expense


##### formát fakturované položky:
```php
array( 
	'name' => 'Název položky', 
	'description' => 'Popis', 
	'quantity' => 1, //množství 
	'unit' => 'ks', //jednotka 
	'unit_price' => 40.83, //cena bez DPH, resp. celková cena, pokud nejste platci DPH 
	'tax' => 20, //sazba DPH, pokud nejste plátcem DPH, zadajte 0 
	'stock_item_id' => 123, //id skladové položky 
	'sku' => 'SKU123', //skladové označení 
	'discount' => 50, //Sleva na položku v %
	'discount_description' => 'Popis slevy',
	'load_data_from_stock' => true //Načíst nevyplněné údaje položky ze skladu
	'use_document_currency' => true //V případě, že je zadáno load_data_from_stock, tak přepočítá skladovou položku, do měny dokladu.
	'AccountingDetail' => array( // účtovnícke detaily položky, 
   	'place' => 'Stredisko Bratislava', //nazov strediska
   	'order' => 'názov', //nazov zákazky 
   	'operation' => 'názov', //činnosť 
   	'type'  => 'item', // typ polozky (item(tovar), service(služba))
   	'analytics_account' => '311', //analytický účet 
   	'synthetic_account' => '000', //syntetický účet
   	'preconfidence' => '5ZV' // predkontácia
   )
)
```

### 3. addTags
Přidá faktuře tagy podle číselníku

#### Parametry:

* **$tags_ids** pole povinné. Pole ID tagů.

Kvůli možnému konfliktu názvů tagů a jejich ID-ček (např. `2019` - rok vs ID) nelze přidávat přímo názvy tagů.
Chcete-li uložit nový tag, je třeba jej předtím přidat `addTag`.

### 4. clients
Vrátí seznam klientů

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/clients.md#get-client-list))

#### Parametry:
* **$params** *pole* povinné. Parametry pro filtrování a stránkování. 
* **$list_info** *bool* nepovinné. Určí zda vrácené data budou obsahovat i údaje o seznamu (celkový počet položek, počet stránek...)

##### možné parametry pro filtrování, číselníky hodnot se nachází pod seznamem parametrů: 
```php
array( 
	'search' => '', //Hledaný výraz v klientovi. Prohledává všechy pole. 
)
```
##### Formát vrácených dat
```php
{ 
	"itemCount": 67, 
	"pageCount": 7, 
	"perPage": 10, 
	"page": 1, 
	"items": [{ "Client": {...}, },...] 
}
```

### 5. delete
Smaže fakturu

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#delete-invoice))

##### Parametry:
* **$id** *int* povinné. Získané z Invoice->id.
 
### 6. deleteInvoiceItem
Smaže položku na faktuře.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#delete-invoice-item))

##### Parametry:
* **$invoice_id** *int* povinné. Získané z Invoice->id. 
* **$id** *int* povinné. Získané z InvoiceItem->id. 

### 7. deleteExpense
Smaže náklad.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/expenses.md#delete-expense))

##### Parametry:
* **$id** *int* povinné. Získané z Expense->id.

### 8. deleteStockItem
Smaže skladovou položku.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/stock.md#delete-stock-item))

##### Parametry:
* **$id** *int* povinné. Získané z StockItem->id.

### 9. edit
Uloží nastavené data a aktualizuje fakturu

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#edit))

##### Parametry: žádné
##### Návratová hodnota: objekt
##### Kódy chyb:
* **1** Id dokladu nemá správný formát 
* **2** Neexistující id dokladu 
* **3** Chyba při editaci faktury. Volání třeba opakovat. 
* **6** Chyba při validaci údajů. Povinné údaje chýbějí nebo nemají správný formát.

### 10. expenses
Vrátí seznam nákladů

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/expenses.md#get-list-of-expenses))

##### Parametry:
* **$params** *pole* povinné. Parametry pro filtrování a stránkování. 
* **$list_info** *bool* nepovinné. Určuje zda vrácené data budou obsahovat i údaje o seznamu (celkový počet položek, počet stránek...) 

### 11. expense
Vrátí detaily nákladu

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/expenses.md#expense-detail))

##### Parametry:
* **$expense_id** *int* povinné. Získané z Expense->id.

### 12. getCountries
Vrátí číselník zemí.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/value-lists.md#country-list))

### 13. getSequences
Vrátí číselník číselných řad podle typů dokumentů.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/value-lists.md#sequences))

### 14. getPDF
Vrátí PDF soubor s fakturou

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#get-invoice-pdf))

##### Parametry:
* **$invoice_id** *int* povinné. Získané z Invoice->id. 
* **$token** *string* povinné. Získané z Invoice->token. 
* **$language** *string* nepovinné. Jazyk požadovaného PDF. Možné hodnoty jsou {slo, cze, eng, deu, rus, ukr, hun, pol, rom, hrv, slv, spa, ita} 

### 15. getTags
Vrátí číselník existujících tagů

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/tags.md#get-list-of-tags))

### 16. invoice
Vrátí detail faktury

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#get-invoice-detail))

##### Parametry:
* **$invoice_id** *int* povinné. Získané z Invoice->id. 

### 17. invoices
Vrátí seznam vystavených faktur

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#get-list-of-invoices))

##### Parametry:
* **$params** *pole* povinné. Parametry pro filtrování a stránkování. 
* **$list_info** *bool* nepovinné. Určuje zda vrácená data budou obsahovat i údaje o seznamu (celkový počet položek, počet stránek...)
 
##### možné parametry pro filtrování, seznam hodnot se nachází pod seznamem parametrů: 

```php
array( 
	'page' => 1, //Stránka 
	'per_page' => 10, //Počet položek na stránku 
	'created' => 0, //Datum vystavení. 
	'delivery' => 0, //Datum dodání.
	'modified' => 0, //Datum poslední změny.
	'type' => 'regular', //Typ faktury. Více typů je možné kombinovat pomocí "|" např. "regular|cancel" 
	'delivery_type' => 'mail', //Typ faktúry. Viíce typů je možné kombinovat pomocí "|" např. "mail|personal" 			'payment_type' => 'transfer', //Typ faktúry. Více typů je možné kombinovat pomocí "|" např. "mail|personal" 
	'status' => 0, //Stav faktury. 
	'client_id' => 1, //ID klienta. Seznam klientů je možné získat metodou clients() 
	'amount_from' => 0, //Suma faktury od 
	'amount_to' => 0, //Suma faktury do 
	'paid_since' => 0, //Faktura uhrazená od 
	'paid_to' => 0, //Faktura uhrazená do 
	'search' => '', //Hledaný výraz ve faktuře. Prohledává všechny pole. 
	'ignore' => '1|2|3', //ID faktur, které se mají ignorovat. 
	'order_no'=> '2016001', //číslo cenové nabídky z níž byla FA vytvořena
)
```

##### Formát vrácených dat

```php
{ 
	"itemCount": 67, 
	"pageCount": 7, 
	"perPage": 10, 
	"page": 1, 
	"items": [{ 
		"Client": {...}, 
		"Invoice": {"id": "8358",...} 
		"InvoicePayment": {}, 
		"InvoiceEmail": {}, 
		"PostStamp": {} 
	},...] 
} 
```

##### Číselníky pro filtrování faktur: Období vystavení a dodaní faktury

```php
Array ( 
	[0] => Všechno 
	[1] => Dnes 
	[2] => Včera 
	[4] => Tento měsíc 
	[5] => Minulý měsíc 
	[8] => Tento kvartál 
	[7] => Minulý rok 
	[6] => Tento rok 
	[3] => od - do //v případě hodnoty od - do je potřeba uvést i parametry created_since a created_to 
)
```
 Typ faktury
```php
Array ( 
	[regular] => Bežná 
	[proforma] => Zálohová faktura 
	[estimate] => Cenová nabídka 
	[cancel] => Dobropis 
	[order] => Přijatá objednávka
	[delivery] => Dodací list
)
```
Způsob dodání
```php
Array ( 
	[mail] => Poštou 
	[courier] => Kurýrem 
	[personal] => Osobní odběr 
	[haulage] => Nákladní doprava
	[pickup_point]  => Odběrní místo
)
```
Způsob úhrady
```php
Array ( 
	[transfer] => Bankovním převodem 
	[cash] => Hotovost 
	[paypal] => Paypal 
	[credit] => Kreditní karta 
	[debit] => Debitní karta 
	[cod] => Dobírka 
	[accreditation] => Vzájemný zápočet 
	[inkaso] => Inkaso
	[gopay] => GoPay
)
```
Stav faktury
```php
Array ( 
	[0] => Všechno 
	[1] => Čekají na uhrazení 
	[2] => Částečně uhrazené 
	[3] => Uhrazené 
	[99] => Po splatnosti 
)
```
Příklad filtrování faktur pomocí ID číselníku
```php
require_once('SFAPIclient/SFAPIclient.php');  // inc. SuperFaktúra PHP-API
$login_email = 'login@example.com';  // moje.superfaktura.cz login email
$api_token = 'abcd1234';  // token from my account
$sf_api = new SFAPIclient($login_email, $api_token);  // create SF PHP-API object
$json_response = $sf_api->invoices(array(
	'sequence_id' => ID, // integer
	'type' => 'regular'
));
```

### 18. markAsSent
Označí fakturu jako odeslanou e-mailem. Užitečné, pokud vytvořené faktury odosíláte vlastním systémem, avšak chcete toto odoslání evidovat i v SuperFaktuře.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#mark-invoice-as-sent-via-email))

##### Parametry:
* **$invoice_id** *int* povinné. Získané z Invoice->id 
* **$email** *string* povinné. E-mailová adresa, kam byla faktura odeslaná. 
* **$subject** *string* nepovinné. Předmět e-mailu. 
* **$message** *string* nepovinné. Text e-mailu. 

### 19. payInvoice
Dodatečně přidá úhradu k faktuře.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#pay-invoice))

##### Parametry:
* **$invoice_id** *int* povinné. Získané z Invoice->id 
* **$amount** *float* povinné. Uhrazená suma. 
* **$currency** *string* nepovinné. Měna úhrady, předvolená CZK. 
* **$date** *string* nepovinné. Datum úhrady, předvolený aktuální datum. 
* **$payment_type** *string* nepovinné. Způsob úhrady, předvolený typ transfer. Možné hodnoty {transfer, cash, paypal, credit, debit, cod, accreditation, inkaso, gopay}
* **$cash_register_id** int nepovinné. ID pokladny

##### Návratová hodnota: objekt

### 20. payExpense
Dodatečně přidá úhradu k nákladu.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/expenses.md#add-expense-payment))

##### Parametry:
* **$expense_id** *int* povinné. Získané z Expense->id 
* **$amount** *float* povinné. Uhradená suma. 
* **$currency** *string* nepovinné. Měna úhrady, předvolená CZK. 
* **$date** *string* nepovinné. Datum úhrady, předvolený aktuální datum. 
* **$payment_type** *string* nepovinné. Způsob úhrady, předvolený typ transfer. Možné hodnoty {transfer, cash, paypal, credit, debit, cod, accreditation, inkaso, gopay}

### 21. save
Uloží nastavené data a vystaví fakturu

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#add-invoice))

##### Parametry: žádné
##### Návratová hodnota: objekt
```php
{
    "error": 0,
    "error_message": "Invoice created",
    "data": {
        "Invoice": {
            "id": "947592",
            "user_id": "15968",
            "user_profile_id": "10156",
            "client_id": "518992",
            "parent_id": null,
            "proforma_id": null,
            "estimate_id": null,
            "sequence_id": "41008",
            "import_type": null,
            "import_id": null,
            "import_parent_id": null,
            "type": "regular",
            "tax_document": null,
            "name": "Faktura test",
            "lang": null,
            "client_data": "{\"Client\":{\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"country_id\":\"191\",\"name\":\"Klient test\",\"ico\":987654321,\"dic\":314,\"ic_dph\":null,\"bank_account\":null,\"email\":null,\"address\":null,\"city\":null,\"zip\":null,\"state\":null,\"country\":null,\"delivery_name\":null,\"delivery_address\":null,\"delivery_city\":null,\"delivery_zip\":null,\"delivery_state\":null,\"delivery_country\":null,\"delivery_country_id\":null,\"phone\":null,\"fax\":null,\"due_date\":null,\"default_variable\":null,\"discount\":null,\"currency\":\"EUR\",\"comment\":null,\"tags\":null,\"demo\":\"0\",\"update_addressbook\":true}}",
            "my_data": "{\"MyData\":{\"id\":\"10156\",\"user_id\":\"15968\",\"country_id\":\"191\",\"company_name\":\"Jan Doczy\",\"ico\":\"41432312\",\"dic\":\"CZ29413893fdsafdasfdsadfasfdjasf\",\"ic_dph\":\"012345678fjdksjfkldajklfdjasklfj\",\"business_register\":\"Okr. s\\u00fad BA 1, odd. SRO, vl. \\u010d 1234\\/B\",\"address\":\"\",\"city\":\"\",\"zip\":\"\",\"tax_payer\":\"1\",\"country\":\"Slovensko\",\"BankAccount\":[{\"id\":\"9998\",\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"default\":\"1\",\"country_id\":\"191\",\"bank_name\":\"UniCredit Bank Slovakia\",\"bank_code\":\"1111\",\"account\":\"1119090001\",\"iban\":\"SK8011110000001119090001\",\"swift\":\"UNCRSKBX\",\"created\":\"2014-10-06 13:25:30\",\"modified\":\"2015-08-21 08:09:07\"},{\"id\":\"10121\",\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"default\":null,\"country_id\":\"191\",\"bank_name\":\"\",\"bank_code\":\"\",\"account\":\"\",\"iban\":\"\",\"swift\":\"\",\"created\":\"2014-10-17 09:05:54\",\"modified\":\"2014-10-17 09:05:54\"},{\"id\":\"10434\",\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"default\":null,\"country_id\":\"191\",\"bank_name\":\"\",\"bank_code\":\"\",\"account\":\"\",\"iban\":\"\",\"swift\":\"\",\"created\":\"2014-11-18 14:29:46\",\"modified\":\"2014-11-18 14:29:46\"},{\"id\":\"10502\",\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"default\":null,\"country_id\":\"191\",\"bank_name\":\"\",\"bank_code\":\"\",\"account\":\"\",\"iban\":\"\",\"swift\":\"\",\"created\":\"2014-11-25 09:33:31\",\"modified\":\"2014-11-25 09:33:31\"},{\"id\":\"10530\",\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"default\":null,\"country_id\":\"191\",\"bank_name\":\"\",\"bank_code\":\"\",\"account\":\"\",\"iban\":\"\",\"swift\":\"\",\"created\":\"2014-11-27 09:20:29\",\"modified\":\"2014-11-27 09:20:29\"},{\"id\":\"10774\",\"user_id\":\"15968\",\"user_profile_id\":\"10156\",\"default\":null,\"country_id\":\"191\",\"bank_name\":\"\",\"bank_code\":\"\",\"account\":\"\",\"iban\":\"\",\"swift\":\"\",\"created\":\"2014-12-15 14:29:54\",\"modified\":\"2014-12-15 14:29:54\"}]}}",
            "items_data": "Polozka test , ",
            "invoice_no": "9",
            "order_no": null,
            "invoice_no_formatted": "201500009",
            "mask": "YYYYNNN",
            "variable": "201500009",
            "constant": "0308",
            "specific": null,
            "payment_type": null,
            "status": "1",
            "home_currency": "EUR",
            "invoice_currency": "EUR",
            "exchange_rate": "1.00000000000000",
            "amount": "15.00",
            "vat": "0.00",
            "discount": "0",
            "items_name": null,
            "issued_by": null,
            "issued_by_phone": "+421000000000",
            "issued_by_email": "email@example.com",
            "paid": "0.00",
            "amount_paid": "0.00",
            "deposit": "0.00",
            "header_comment": "",
            "comment": "Toto je poznamka.",
            "internal_comment": null,
            "created": "2015-09-02 00:00:00",
            "modified": "2015-09-02 08:53:35",
            "recurring": null,
            "paydate": null,
            "delivery": "2015-09-02 00:00:00",
            "delivery_type": null,
            "due": "2015-09-16",
            "demo": "0",
            "token": "bd1f145f",
            "tags": "",
            "rounding": "item",
            "vat_transfer": null,
            "special_vat_scheme": null,
            "issued_by_web": null,
            "summary_invoice": "0",
            "show_items_with_dph": false,
            "show_special_vat": false
        },
        "Client": {
            "id": "518992",
            "user_id": "15968",
            "user_profile_id": "10156",
            "country_id": "191",
            "name": "Klient test",
            "ico": "987654321",
            "dic": "314",
            "ic_dph": null,
            "bank_account": null,
            "email": null,
            "address": null,
            "city": null,
            "zip": null,
            "state": null,
            "country": null,
            "delivery_name": null,
            "delivery_address": null,
            "delivery_city": null,
            "delivery_zip": null,
            "delivery_state": null,
            "delivery_country": null,
            "delivery_country_id": null,
            "phone": null,
            "fax": null,
            "due_date": null,
            "default_variable": null,
            "discount": null,
            "currency": "EUR",
            "comment": null,
            "tags": null,
            "created": "2015-09-02 08:52:49",
            "modified": "2015-09-02 08:53:35",
            "demo": "0"
        },
        "InvoicePayment": [],
        "InvoiceEmail": [],
        "PostStamp": [],
        "Tag": [],
        "Logo": [
            {
                "id": "24688",
                "model": "User",
                "foreign_key": "10156",
                "dirname": "img",
                "basename": "10156_logo.jpg",
                "checksum": "5239f6774ced537687cf90c4561dd438",
                "group": "logo",
                "alternative": null,
                "created": "2014-11-27 09:20:29",
                "modified": "2014-11-27 09:20:29"
            }
        ],
        "Signature": {
            "id": "25789",
            "model": "User",
            "foreign_key": "10156",
            "dirname": "img",
            "basename": "10156_sig.png",
            "checksum": "d20820f675efdedaef5839a6da30bf97",
            "group": "signature",
            "alternative": null,
            "created": "2014-12-16 14:28:09",
            "modified": "2015-04-15 09:41:08"
        },
        "MyData": {
            "id": "10156",
            "user_id": "15968",
            "country_id": "191",
            "company_name": "Jan Doczy",
            "ico": "41432312",
            "dic": "CZ29413893fdsafdasfdsadfasfdjasf",
            "ic_dph": "012345678fjdksjfkldajklfdjasklfj",
            "business_register": "Okr. súd BA 1, odd. SRO, vl. č 1234/B",
            "address": "",
            "city": "",
            "zip": "",
            "tax_payer": "1",
            "country": {
                "id": "191",
                "name": "Slovensko",
                "iso": "sk",
                "eu": "1"
            },
            "BankAccount": [
                {
                    "id": "9998",
                    "user_id": "15968",
                    "user_profile_id": "10156",
                    "default": "1",
                    "country_id": "191",
                    "bank_name": "UniCredit Bank Slovakia",
                    "bank_code": "1111",
                    "account": "xxxxxxxx",
                    "iban": "SKxxxxxxxxxxxxxxxxxxxxxxx",
                    "swift": "UNCRSKBX",
                    "created": "2014-10-06 13:25:30",
                    "modified": "2015-08-21 08:09:07"
                }
            ]
        },
        "ClientData": {
            "user_id": "15968",
            "user_profile_id": "10156",
            "country_id": "191",
            "name": "Klient test",
            "ico": 987654321,
            "dic": 314,
            "ic_dph": null,
            "bank_account": null,
            "email": null,
            "address": null,
            "city": null,
            "zip": null,
            "state": null,
            "country": null,
            "delivery_name": null,
            "delivery_address": null,
            "delivery_city": null,
            "delivery_zip": null,
            "delivery_state": null,
            "delivery_country": null,
            "delivery_country_id": null,
            "phone": null,
            "fax": null,
            "due_date": null,
            "default_variable": null,
            "discount": null,
            "currency": "EUR",
            "comment": null,
            "tags": null,
            "demo": "0",
            "update_addressbook": true,
            "Country": {
                "id": "191",
                "name": "Slovensko",
                "iso": "sk",
                "eu": "1"
            }
        },
        "InvoiceItem": [
            {
                "id": "2384612",
                "invoice_id": "947592",
                "user_id": "15968",
                "user_profile_id": "10156",
                "stock_item_id": null,
                "name": "Polozka test",
                "description": "",
                "sku": null,
                "quantity": null,
                "unit": null,
                "unit_price": 15,
                "tax": "0",
                "discount": 0,
                "discount_description": null,
                "ordernum": "0",
                "unit_price_discount": 15,
                "item_price": 15,
                "item_price_no_discount": 15,
                "discount_no_vat": 0,
                "discount_with_vat": 0,
                "discount_with_vat_total": 0,
                "discount_no_vat_total": 0,
                "unit_price_vat": 15,
                "unit_price_vat_no_discount": 15,
                "item_price_vat": 15,
                "item_price_vat_no_discount": 15,
                "item_price_vat_check": 15
            }
        ],
        "Summary": {
            "vat_base_separate": [
                15
            ],
            "vat_base_total": 15,
            "vat_separate": [
                0
            ],
            "vat_total": 0,
            "invoice_total": 15,
            "discount": 0
        },
        "SummaryInvoice": {
            "vat_base_separate_positive": [
                15
            ],
            "vat_base_separate_negative": [
                0
            ],
            "vat_separate_positive": [
                0
            ],
            "vat_separate_negative": [
                0
            ]
        },
        "UnitCount": [],
        "Paypal": "https://www.paypal.com/",
        "PaymentLink": ""
    }
}
```
##### Kódy chyb:
* **2** Data nebyly odeslané metodou POST. 
* **3** Špatná data. Odeslané data nemají správný formát. 
* **5** Validačný chyba. Povinné údaje chýbějí nebo nejsou správně vyplněné. 

### 22. setExpense
Nastaví hodnoty pro náklad
##### Parametry:
* **$key** mixed povinné. Může být string nebo pole. Pokud je string, nastaví se konkrétní hodnota v $data['Expense'][$key]. Pokud je pole, nastaví se více hodnot najednou. 
* **$value** mixed nepovinné. Pokud je $key string, hodnota $value se nastaví v $data['Expense'][$key]. Pokud je $key pole, $value se ignoruje. 

Příklad použití:
```php
$api->setExpense('name', 'název nákladu');
```
```php
$api->setExpense(array( 
			'name' => 'název nákladu', // povinný udaj 
			'amount' => 10, // suma bez DPH 
			'vat' => 20, // DPH v procentech 
			'variable' => '123456', // variabilní symbol 
			'constant' => '0308', // konstanuložítní symbol 
			'attachment' => base64_encode(file_get_contents('/tmp/foo.pdf')),
));
```

Seznam možných vlastností nákladu
* **name** - název nákladu (povinný údaj) 
* **amount** - suma bez daně 
* **vat** - DPH (v procentech) 
* **already_paid** - byla už faktura uhrazená? true/false 
* **created** - datum vystavení 
* **comment** - komentář 
* **constant** - konstantní symbol 
* **delivery** - datum dodání 
* **due** - datum splatnosti 
* **currency** - měna, ve které je faktura vystavená. Možnosti: EUR, USD, GBP, HUF, CZK, PLN, CHF, RUB 
* **payment_type** - Způsob úhrady, číselník hodnot 
* **specific** - specifický symbol 
* **type** - typ faktury. Možnosti: invoice - přijatá faktura, bill - pokladní blok, internal - interní doklad, contribution - odvody 
* **variable** - variabilní symbol 
* **taxable_supply** - Datum uplatnění DPH
* **document_number** - Číslo dokladu. Například číslo došlé faktury, číslo pokladního bloku a podobně.
* **expense_category_id** - ID příslušné kategorie. Seznam všech kategorií je možné získat pomocí funkce getExpenseCategories().
* **atttachment** - soubor přílohy ve formátu base64. Maximální velikost souboru jsou 4MB. Povolené typy: `jpg`, `jpeg`, `png`, `tif`, `tiff`, `gif`, `pdf`, `tmp`, `xls`, `xlsx`, `ods`, `doc`, `docx`, `xml`, `csv`, `msg`

### 23. setInvoice
Nastaví hodnoty pro fakturu
##### Parametry:
* **$key** mixed povinné. Může být string nebo pole. Pokud je string, nastaví se konkrétní hodnota v $data['Invoice'][$key]. Pokud je pole, nastaví se více hodnot najednou. 
* **$value** mixed nepovinné. Pokud je $key string, hodnota $value se nastaví v $data['Invoice'][$key]. Pokud je $key pole, $value se ignoruje.

Příklad použití:
  ```php 
$api->setInvoice('name', 'nazov faktury');
  ```
  ```php   
$api->setInvoice(array(
	'name' => 'nazov faktury',
	'variable' => '123456',
	'constant' => '0308',
	'bank_accounts' => array(
		array(
			'bank_name' => 'MyBank',
			'account' => '012345678',
			'bank_code' => '1234',
			'iban' => 'SK0000000000000000',
			'swift' => '12345',
		)
	)
));
  ``` 

Seznam možných vlastností faktury
* **already_paid** - byla už faktura uhrazená? true/false
* **cash_register_id** - int nepovinné. ID pokladny do které bude evidovaná platba (v případě EET pokladny bude tato úhrada zaevidována do EET)
* **created** - datum vystavení 
* **comment** - komentář 
* **constant** - konstantný symbol 
* **delivery** - Zdanitelné plnění
* **delivery_type** - spůsob dodání, číselník hodnot 
* **deposit** - uhrazená záloha 
* **discount** - sleva v %
* **discount_total** - nominální sleva, použije se pouze pokud není nastavena vlastnost discount
* **due** - datum splatnosti 
* **estimate_id** - ID cenové nabídky, na základě které je faktura vystavená 
* **header_comment** - Text nad položkami faktury 
* **internal_comment** - Interní poznámka, nezobrazuje se klientovi 
* **invoice_currency** - měna, ve ktoré je faktura vystavená. Možnosti: EUR, USD, GBP, HUF, CZK, PLN, CHF, RUB 
* **invoice_no_formatted** - číslo faktury 
* **issued_by** - fakturu vystavil jméno 
* **issued_by_phone** - fakturu vystavil telefon 
* **issued_by_email** - fakturu vystavil e-mail
* **issued_by_web** - webová stránka zobrazená na faktuře 
* **name** - název faktury
* **paydate** - datum úhrady 
* **payment_type** - Způsob úhrady, číselník hodnot 
* **proforma_id** - ID proforma faktury, na základě ktoré se vystavuje ostrá faktura. Ostrá faktura tak přebere údaje o uhrazené záloze
* **parent_id** - ID faktury, ke které chcete vystavit dobropis (opravný daňový doklad)
* **rounding** - Způsob zaokrouhlování DPH. 'document' => za celý dokument, 'item' => po položkách (předvolená hodnota), 'item_ext' => maloobchod (doporučený typ pro eshopy) 
* **specific** - specifický symbol 
* **sequence_id** - ID číselníku, seznam číselníků je možné získat metodou getSequences 
* **type** - typ faktury. Možnosti: regular - běžná faktura, proforma - zálohová faktura, cancel - dobropis, estimate - cenová nabídka, order - přijatá objednávka 
* **variable** - variabilní symbol (v případě nevyplnění variabilního symbolu se automaticky doplní číslo faktury)
* **bank_accounts** - (pole) seznam bankovních účtů (viz příklad výše)
* **order_no** - číslo objednávky
* **logo_id** - ID loga

### 24. sendInvoiceEmail
Odešle fakturu emailem

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#send-invoice-via-mail))

##### Parametry:
* **$options** *array*, povinné. 
Príklad použitia:

```php
$api->sendInvoiceEmail(array( 
			'invoice_id' => 123456, // povinné 
			'to' => 'example@example.com', // povinné 
			'cc' => array( 'examplecc@examplecc.com' ), 
			'bcc' => array( 'examplebcc@examplebcc.com' ),
			'pdf_language' => eng, //pokud není nastavený nastaví se automaticky 
			// 'subject' => 'Předmět', // pokud není nastavený subject nastaví se automaticky z e-mailové šablony v nastavení 
			// 'body' => 'Zpráva' // pokud není nastavené body nastaví se automaticky z e-mailové šablony v nastavení 
));
```

Seznam možných nastavení
* **invoice_id** *integer*, id faktury, kterou chcete odeslat (povinné) 
* **to** *string*, na kterou e-mailovou adresu se má faktura odeslat (povinné) 
* **cc** *array*, cc 
* **bcc** *array*, bcc 
* **subject** *string*, předmět 
* **body** *string*, tělo zprávy 
* **pdf_language** *string*, jazyk dokladu

Seznam možných jazyků pro doklady:
* 'slo' => slovenština
* 'cze' => čeština
* 'eng' => angličtina
* 'deu' => němčina
* 'rus' => ruština
* 'ukr' => ukrajinština
* 'hun' => maďarština
* 'pol' => poľština
* 'rom' => rumunština
* 'hrv' => chorvatština
* 'slv' => slovinština
* 'spa' => španělština
* 'ita' => italština

### 25. sendInvoicePost
Odešle fakturu poštou

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#send-invoice-via-post))

##### Parametry:
* **$options** *array*, povinné. 

Příklad použití:
```php
$api->sendInvoicePost(array( 
	'invoice_id' => 123456, // povinné 
	/** > POKUD NEJSOU NASTAVEÉ VYTÁHNOU SE Z FAKTURY < *
	****************************************************** 
	'delivery_name' => 'SuperFaktura', 
	'delivery_address' => 'Adresa 123', 
	'delivery_city' => 'Město',
	'delivery_zip' => '12345', 	
	'delivery_state' => 'Česká republika' 
	******************************************************/ 
));
```
Seznam možných nastavení
invoice_id integer, id faktury, kterou chcete odeslat (povinné) 

### 26. stockItemEdit
Aktualizuje skladovou položku

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/stock.md#edit-stock-item))

##### Parametry:
* **$item** *array*, povinné. 

Příklad použití:
```php
$api->stockItemEdit(array( 
			'stock_item_id' => 123456, // povinné 
			'name' => '*New stock item name', // nový název skladové položky 
			'sku' => 'NEWST06K1T3M1D' // nové SKU 
));
```
Seznam možných nastavení
* **id** *integer*, id skladové položky 
* **name**  *string*, název skladové položky 
* **description** *string*, popis skladové položky 
* **sku** *string*, skladové číslo 
* **unit_price** *integer*, jednotková cena bez DPH 
* **vat** *integer*, DPH v procentech 
* **stock** *integer*, počet kusů na skladu. Pokud se vynechá nebude se sledovat stav zásob. 
* **unit** *string*, jednotka např. ks, mm, m2, dm3, l. 

### 27. addStockItem
Přidá skladovou položku

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/stock.md#add-stock-item))

##### Parametry:
* **$item** *array*, povinné. 

Příklad použití:
```php
$api->addStockItem(array( 
			'name' => 'Stock item example', // název skladové položky 
			'description' => 'Stock item description',  
			'sku' => 'SKU12345REF', // skladové číslo 
			'unit_price' => 10, // jednotková cena bez DPH 
			'vat' => 20, // DPH v procentech 
			'stock' => 100 // počet kusů na skladu, pokud není definované nebudou se sledovat pohyby 
));
```
Seznam možných nastavení
* **name** *string*, název skladové položky 
* **description** *string*, popis skladové položky 
* **sku** *string*, skladové číslo 
* **unit_price** *integer*, jednotková cena bez DPH 
* **vat** *integer*, DPH v procentech 
* **stock** *integer*, počet kusů na skladu. Pokud se vynechá nebude se sledovat stav zásob. 
* **unit** *string*, jednotka např. ks, mm, m2, dm3, l. 

### 28. addStockMovement
Přidá pohyb na skladě

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/stock.md#add-stock-movement))

##### Parametry:
* **$item** *array*, povinné. 

Příklad použití:
```php
$api->addStockMovement(array( 
			'stock_item_id' => 0, // id skladové položky 
			'name' => 'Stock item example', // název skladové položky 
			'description' => 'Stock item description', 
			'sku' => 'SKU12345REF', // skladové číslo 
			'unit_price' => 10, // jednotková cena bez DPH 
			'vat' => 20, // DPH v procentech 
			'stock' => 100 // počet kusů na skladu, pokud není definovaný nebudou se sledovat pohyby 
));
```
Seznam možných nastavení
* **stock_item_id** *iteger*, id skladové položky, ke které chceme přidat pohyb 
* **quantity** *integer*, pohyb - záporné číslo je výdaj, kladné příjem 
* **note** *string*, popis pohybu 
* **created** *date* 'YEAR-MONTH-DAY' format, datum 

### 29. setClient
Nastaví hodnoty pro klienta
##### Parametry:
Shodné se setInvoice

Seznam možných vlastností klienta
* **address** - adresa 
* **bank_account** - bankovní účet 
* **city** - město 
* **comment** - komentář 
* **country_id** - ID země, číselník zemí je možné získat metodou getCountries 
* **country_iso_id** ISO 3166-1 (Alpha-2) kód země 
* **country** - vlastní název země 
* **delivery_address** - dodací adresa 
* **delivery_city** - dodací město 
* **delivery_country** - vlastní dodací země 
* **delivery_country_id** - ID dodací země 
* **delivery_country_iso_id** ISO 3166-1 (Alpha-2) kód země 
* **delivery_name** - název klienta pro dodání 
* **delivery_zip** - dodací PSČ 
* **dic** - DIČ 
* **email** - e-mail 
* **fax** - fax 
* **ic_dph** - IČ DPH 
* **ico** - IČ 
* **name** - název klienta 
* **phone** - telefon 
* **delivery_phone** - telefonní číslo pro dodání
* **zip** - PSČ 
* **match_address** (boolean) - pokud je tento parameter nastavený, do hledaní klienta vstupuje i adresa. 
* **update_addressbook** (boolean) - při vystavení faktury aktualizuje údaje klienta

V případě zahraničního klienta je potřebné správně vyplnit country_id. Když country_id zůstane prázdné, použije se předdefinovaná hodnota pro Českou republiku. Na zjištění country_id konkrétní krajiny použijte funkci [getCountries()](#12-getcountries).

### 30. stockItems
Vrátí seznam skladových položek

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/stock.md#get-list-of-stock-items))

##### Parametry:
* **$params** pole povinné. Parametry pro filtrování a stránkování. 
* **$list_info** bool nepovinné. Určuje, jestli vrácené data budou obsahovat i údaje o seznamu (celkový počet položek, počet stránek...)

##### možné parametry pro filtrování: 
```php
array( 
	'page' => 1, //Stránka 
	'per_page' => 10, //Počet položek na stránku 
	'price_from' => 0, //Cena od 
	'price_to' => 0, //Cena do
	'sku' => '', // Unikátní číslo skladové položky pomůže položku jednoduše identifikovat
	'search' => '', //Hledaný výraz. Prohledáva všechny pole. 
)
```
Formát vrácených dat
{ 
	"itemCount": 67, 
	"pageCount": 7, 
	"perPage": 10, 
	"page": 1, 
	"items": [{ "StockItem": {...}, 
	}, ...] 
}

### 31. stockItem
Vrátí detail skladové položky

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/stock.md#view-stock-item-details))

##### Parametry:
* **$stock_item_id** int povinné. Získané z StockItem->id. 

### 32. addContactPerson($data)
Přidá novou kontaktní osobu ke stávajícímu klientovi. Návratová hodnota je objekt (JSON). Pokud operace proběhla bez problémů je nastaven atribut status na hodnotu (string) 'SUCCESS'.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/contact-persons.md#add-contact-person))

```php
$result = $api->addContactPerson(array(
    		'client_id' => ID_KLIENTA,  // ID existujuceho klienta
    		'name' => 'Contact Person',  // Nazov kotaktnej osoby
    		'email' => 'email@example.com'  // Email pre kontaktnu osobu
));
if ($result->status === 'SUCCESS')
    ...;
 ```
### 33. getLogos()
Vrátí detaily všech log. Návratová hodnota je objekt (JSON).

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/value-lists.md#logos))
 
### 34. getExpenseCategories()
Vrátí seznam všech kategorií nákladů. Návratová hodnota je objekt (JSON).

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/value-lists.md#expense-categories))
 
## 35. setInvoiceSettings($settings)
nastaví vlastnosti  pri zobrazovaní faktúry
##### Parametre 
* **$settings** *array*, povinné.
Zoznam možných vlastností faktúry:
* **language** *string*, nastaví jazyk faktúry.
* **signature** *boolean*, zobrazovat podpis.
* **payment_info** *boolean*, zobrazovať informáciu o úhrade.
* **online_payment** *boolean*, zobrazovat online platby.
* **bysquare** *boolean*, zobrazovat pay by square    
* **paypal** *boolean*, zobrazovat PayPal
* **callback_payment** *string*, URL, která sa automaticky zavolá po přidání úhrady k faktuře. GET parametr `invoice_id` bude přidán k URL. Pro odeslanou URL `https://example.com/callback/`, výsledná URL pro invoice_id 123 bude `https://example.com/callback/?invoice_id=123` nebo `https://example.com/callback/?invoice_id=123&secret_key={KEY}`.
                                                                                                                                            Parametr `secret_key` může být součástí poslané URL (`https://example.com/callback/?secret_key=SECRET-KEY`) nebo být nastaven v profilu.  

## 36. setInvoiceExtras($extras)
rozšířené parametry faktury
##### Parametre 
* **$extras** *array*, povinné.

Zoznam možných parametrov:
* **pickup_point_id** *int* ID odběrného místa pro Zásilkovnu
* **weight** *float*, váha balíku,
* **parcel_count** *int*, počet balíků,
* **insurance**, *float*, hodnota pojištění,
* **dimension**, *string*, rozměr balíku v cm (d x š x v)
* **tracking_number** *string*, podací číslo
* **uuid** *string*, volitelný jednoznačný identifikátor faktury

## 37. cashRegister($cash_register_id)
Vrátí detail pokladny včetne pohybů

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/cash-register-item.md#get-cash-register-items))

##### Parametre 
* **cash_register_id** *int* ID pokladny

## 38. sendSMS($data)
Odešle SMS.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/other.md#send-sms-reminder))

##### Parametre 
* **$data** *array*, povinné.

Zoznam možných parametrov:
* **$invoice_id** *int*, povinné. ID faktury
* **$text** *string*, povinné  Text SMS.
* **$phone** *string*, pokud není zadané tel. číslo použije se tel. číslo klienta z faktury

## 39. setMyData
Nastaví hodnoty pro údaje dodavatele na faktuře
##### Parametre
* **$key** mixed povinné. Může být string nebo pole. Pokud je string, nastaví se konkrétní hodnota v $data['MyData'][$key]. Pokud je pole, nastaví se více hodnot najednou. 
* **$value** mixed nepovinné. Pokud je $key string, hodnota $value se nastaví v $data['MyData'][$key]. Pokud je $key pole, $value se ignoruje.

Příklad použití:
```php 
$api->setMyData('ic_dph', 'SK1234567890');
```
```php
$api->setMyData(array(
	'company_name' => 'Testovacia firma',
	'ic_dph' => 'SK1234567890',
	'country_id' => '57'
));
  ``` 

Seznam možných úprav v údajích dodavatele:
* **country_id** - ID země, číselník zemí je možné získat metodou getCountries
* **company_name** - Název společnosti
* **dic** - DIČ
* **ic_dph** - IČ DPH
* **business_register** - Zápis v obchodním rejstříku
* **address** - Adresa společnosti - ulice a číslo
* **city** - Adresa společnosti - město
* **zip** - Adresa společnosti - PSČ
* **update_profile** - Boolean hodnota. Pokud se pošle s hodnotou true, aktualizují se i údaje v profilu. Pokud se pošle s hodnotou false nebo nepošle vůbec, údaje se změní jen na faktuře, ale profilové údaje zůstanou nezměněny.

### 40. getInvoiceDetails($ids)
vrátí detaily faktur

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/invoice.md#get-invoice-details))

##### Parametre 
* **$ids** *array*, limit 100

Příklad použití:
```php
$api->getInvoiceDetails(array(1, 2, 3, 4, 5, 6, 7, 8));
  ```

### 41. getUserCompaniesData($getAllCompanies)
Vrátí údaje o firmě, do které jste momentálně přihlášen, případně o všech firmách, ke kterým má účet přístup.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/other.md#get-user-companies-data))

##### Parametre 
* **$getAllCompanies** bool nepovinné. Pokud je parametr true, vrací údaje o všech firmách, ke kterým má účet přístup. Default je false - vrátí údaje pouze o firmě, ve které je účet momentálně přihlášen.

Příklad použití:
```php
$api->getUserCompaniesData();
$api->getUserCompaniesData(true);
  ```
### 42. createRegularFromProforma($proforma_id)
vystaví ostrou fakturu ze zálohové faktury

##### Parametre 
* **$proforma_id** *int* povinné. Id zálohové faktury

Příklad použití:
```php
$api->createRegularFromProforma(123);
  ```
  
### 43. setEstimateStatus($estimate_id, $status)
změní stav cenové nabídky

##### Parametre 
* **$estimate_id** *int* povinné. Id enové nabídky
* **$status** *int* povinné. Id stavu nabídky

Seznam možných stavů cenové nabídky:
*  1 => neschválena
*  2 => schválena
*  3 => zamítnuta



### 44. getBankAccounts()

Vrátí seznam bankovních účtů.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/bank-account.md#get-list-of-bank-accounts))

```php
$api->getBankAccounts();
```

### 45. addBankAccount(array $data)

Přidá bankovní účet.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/bank-account.md#add-bank-account))

##### Parametry

* **$data** *array* povinné. Údaje o bankovním účtu

Seznam možných vlastností bankovního účtu:
* **bank_account** - číslo účtu
* **bank_code** - čislo banky
* **bank_name** - název banky
* **default** - je účet přednastavený?
* **iban** - IBAN
* **show** - zobrazuj účet na dokumentech
* **swift** - SWIFT

```php
$api->addBankAccount([
    'iban' => 'CZ0000000123',
    'swift' => 'ABCDE12',
    'bank_name' => 'AbcBanka',
    'default' => 1,
]);
```

### 46. updateBankAccount(int $id, array $data)

Uprav bankovní účet.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/bank-account.md#update-bank-account))

##### Parametry

* **$id** *int* povinné. ID bankovního účtu
* **$data** *array* povinné. Údaje o bankovním účtu

Seznam možných vlastností bankovního účtu:
* **bank_account** - číslo účtu
* **bank_code** - čislo banky
* **bank_name** - název banky
* **default** - je účet přednastavený?
* **iban** - IBAN
* **show** - zobrazuj účet na dokumentech
* **swift** - SWIFT

```php
$api->updateBankAccount(123, [
    'bank_name' => 'Originálna Fiktívna Banka',
    'default' => 0,
]);
```


### 47. deleteBankAccount(int $id)

Smaže bankovní účet.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/bank-account.md#delete-bank-account))

##### Parametry

* **$id** *int* povinné. ID bankovního účtu

```php
$api->deleteBankAccount(123);
```



### 48. addTag(array $data)

Přidá nový tag.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/tags.md#add-tag))

##### Parametry

* **$data** *array* povinné. Údaje o tagu

Seznam možných vlastností tagu:
* **name** - název tagu

```php
$api->addTag(['name' => 'nový tag',]);
```


### 49. updateTag(int $id, array $data)

Upraví existující tag.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/tags.md#edit-tag))

##### Parametry

* **$id** *int* povinné. ID tagu
* **$data** *array* povinné. Údaje o tagu

Seznam možných vlastností tagu:
* **name** - název tagu

```php
$api->editTag(123, ['name' => 'starý tag',]);
```

### 50. deleteTag(int $id)

Smaže tag.

([všeobecná REST API dokumentace](https://github.com/superfaktura/docs/blob/master/tags.md#delete-tag))

##### Parametry

* **$id** *int* povinné. ID tagu

```php
$api->deleteTag(123);
```


  
### Autorizace
Pro přihlášení se do API je potřebný e-mail, na který je účet zaregistrovaný a API Token, který je možné nalézt v Nástroje > API.
Samotná autorizace se vykonáva pomocí hlavičky "Authorization", která má nasledující tvar:
```php
"Authorization: SFAPI email=EMAIL&apikey=APITOKEN&company_id=COMPANYID"
```

company_id je nepovinný údaj, uvádí se pouze v případě, že máte pod vaším emailů vytvořených více společností a potřebujete určit, se kterou chcete pracovat

> **Tuto hlavičku musí obsahovat každý request na SF API!** 

### Vystavení faktury
Pokud se Vám nelíbí náš SF API klient a chcete si faktury vystavovat po svém:
Endpoint pro vystavání faktury se nachází na adrese https://moje.superfaktura.cz/invoices/create
Data pro vystavení faktury jsou očekávána ve formátu JSON v $POST['data'] v nasledující formě:
```php
$data = array( 
	'Invoice' => array( //všechny položky jsou nepovinné, v připadě že nejsou uvedené, budu doplněné automaticky 
				'name' => 'název faktury', 
				'variable' => '123456', 
				'constant' => '0308', 
				'specific' => '2015', 
				//specifický symbol 
				'already_paid' => true, // byla už faktura uhrazena? 
				'invoice_no_formatted' => '2015001', //pokud není uvedené, SF ho doplní podle číselníku
				'created' => '2015-12-28', //datum vystavení 
				'delivery' => '2015-12-28', //datum dodaní 
				'due' => '2015-12-28', //datum splatnosti 
				'comment' => 'komentář', 
	), 
	'Client' => array( 
				'name' => 'Tomáš Janák', 
				'ico' => '12345678', 
				'dic' => '12345678', 
				'ic_dph' => 'CZ12345678', 
				'email' => 'info@superfaktura.cz', 
				'address' => 'adresa', 
				'city' => 'město', 
				'zip' => 'psč', 
				'phone' => 'telefon', 
	), 
	'InvoiceItem' => array( array( 
					'name' => 'Superfaktura.cz', 
					'description' => 'Předplatné', 
					'quantity' => 1, 
					'unit' => 'ks', 
					'unit_price' => 150.83, 
					'tax' => 21 
				), 
				array( 
					'name' => 'Druhá položka', 
					'description' => '', 
					'quantity' => 10, 
					'unit' => 'ks', 
					'unit_price' => 5, 
					'tax' => 15 
				) 
	) ); 
// Samotný request s použitím např. Requests knihovna potom může vypadat následovně:
Requests::register_autoloader(); 
$response = Requests::post('https://moje.superfaktura.cz/invoices/create', 
		$headers, 
		array('data' => json_encode($data)) 
); 
$response_data = json_decode($response->body, true); 
// výsledkem tohto volání je JSON odpověď v nasledující formě 
$response_data = array( 
			'error' => 0, 
			'error_message' => 'Chybová hláška', 
			'data' => array(), 
);
```
V případě, pokud došlo k chybě, bude error = 1 a error_message bude obsahovat popis chyby, která nastala. V případě, že chyb nastalo více, bude error_message obsahovat pole s chybovými hláškami. 

Pokud byla faktura úspešně vytvořená, bude v klíči data uložené kompletní informace o vytvořené faktuře. 

### PDF faktury
Po vytvoření faktury je možné stáhnut její PDF na adrese 
```php
https://moje.superfaktura.cz/invoices/pdf/ID_FAKTURY/token:TOKEN
```
kde ID FAKTURY se nachází v $data['Invoice']['id'] a token v $data['Invoice']['token']. 

### Zaevidovanie EET pohybu
Pro správné zaevidování platby do EET je potřebné mít vytvořenou EET pokladnu s platným certifikátem a odpovídajícím ID provozovny. Pohyb můžeme zaevidovat dvěma způsoby, při obou je nutné znát ID EET pokladny vytvořené v SuperFaktuře.

* Při vytváření faktury je nutné do setInvoice nastavit already_paid (což rozhoduje o tom, zda se faktura vystaví jako uhrazená, nebo neuhrazená) na true, dále je nutné nastavit cash_register_id (ID EET pokladny) s odpovídající měnou faktury
```php
$api->setInvoice(array(
  'type' => "regular",
  'already_paid' => true,
  'cash_register_id' => 879
));
```
* [Pomocí funkce payInvoice](#19-payinvoice) (měna úhrady a EET pokladny musí být shodná)
```php
$api->payInvoice(1459738, null, 'CZK', null, 'transfer', 879);
```

### Kvůli výpadku nepřišel response

V případě, že volání vystavení faktury nevrátilo response - vypadl internet, nepřišla odpověď do timeoutu a pod. - je možné dodatečně zjistit response pro toto volání a zamezit tak např. duplicitnímu vystavení faktury.

K faktuře je možné získat unikátní identifikátor (ne `invoice id`).
Vzhledem k tomu, že jde o checksum, doporučujeme v datech faktury uvádět jedinečný údaj ke každé objednávce (např. číslo objednávky).

Postup:
1. standardní vystavení faktury
2. `$api->save()`
3. `$checksum = $api->getChecksum()`
4. vybuchly internety a nemáme odpověď do timeoutu
5. `$response = $api->getResponseByChecksum($checksum)`

`$response` obsahuje původní response faktury, který jste poprvé nedostali.
Response je možné získat pro volání staré maximálně 3 měsíce.
Samozřejmě volání `getResponseByChecksum` je nutné také zkontrolovat pro případnou chybovou odpověď.

# Laravel UI

<a href="https://packagist.org/packages/badore/contabi_form"><img src="https://img.shields.io/packagist/dt/badore/contabi_form" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/badore/contabi_form"><img src="https://img.shields.io/packagist/v/badore/contabi_form" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/badore/contabi_form"><img src="https://img.shields.io/packagist/l/badore/contabi_form" alt="License"></a>

## Introduction
Laravel easy form manager based on bootstrap

## Official Documentation


### Installation

The scaffolding  is located in the `badore/contabi_form` Composer package, which may be installed using Composer:

```bash
composer require badore/contabi_form
```

Once the `badore/contabi_form` package has been installed, you may install the frontend scaffolding using the `contabiform` Artisan command:

```bash
// Generate basic scaffolding...
php artisan contabiform:zacca

```

### Basic Usage
Controller
```bash
use Badore\ContabiForm\ContabiForm;

class DoctorController extends Controller
{
   	
	public function create(){
		
		$form = new ContabiForm('row');
		
		return view('doctor.create',compact('form'));
	}
```

Select your form `new ContabiForm('horizontal')` 
`new ContabiForm('inline')`
`new ContabiForm('row')`

View
`$form->open('POST','route')`

### Methods

`$form->open('POST','route')`      `$form->open('GET','route')`     // start the form

`$form->input('nome', 'required', 4)`      //input text
per tutti i campi input i valori sono: ['titolo'], ['required' -o- 'null'], [lunghezza: es 4]

`$form->inputData('data', null, 1)` //data con bootstrap datepicker
`$form->inputMoney('importo', null, 1)` //money es: 125,00
`$form->file('file', 'required')`
`$form->email('email', required , 4)` //email

`$form->select('titolo', array(), required , 2)` //select
['titolo'], [array], ['required' -o- 'null'], [lunghezza: es 4]

`$form->textarea('testo', required)` //textarea

// disponibile solo per -- new Form('row')`;--
`$form->row()` // apre la riga
     `$form->input('nome', 'required')` //input text
`$form->rowclose()` // chiude la riga

`$form->button('Salva', 'success')` // button

`$form->close()` // chiude il form


## Security Vulnerabilities

Please review [our security policy](https://github.com/badore/contabi_form/security/policy) on how to report security vulnerabilities.

## License

Laravel UI is open-sourced software licensed under the [MIT license](LICENSE.md).

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
##### Start the form
`$form->open('POST','doctors.store')`      `$form->open('GET','doctors.store')`    

##### Input text
`$form->input('title', 'required', 4)`      
Params: ['title'] (also included for `name` and `id`, ['required' -or- 'null'], [lenght: es 4]

##### input Date (require bootstrap datepicker)
`$form->inputData('data', null, 1)` 

##### input money (number)
`$form->inputMoney('importo', null, 1)` //money es: 125,00

##### input file
`$form->file('file', 'required')`

##### input email
`$form->email('email', required , 4)` 

##### input select
`$form->select('titolo', array(), required , 2)` 

Params: ['title'], [array values], ['required' -o- 'null'], [lenght: es 4]

##### input
`$form->textarea('testo', required)` 

##### Form row example

```bash
$form->row() // start row
     $form->input('address', 'required', 3) 
	 $form->inputData('date', null, 1) 
	 $form->inputMoney('amount', null, 1) 
	 $form->select('cities', array(), required , 2) 
$form->rowclose() // close row
```

#####  Button
`$form->button('Save', 'success')` 

Params: ['title'], ['bootstrap color: success, info, warning, danger, dark, light']

##### Form close
`$form->close()` 



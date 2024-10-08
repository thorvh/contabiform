<?php

namespace Badore\ContabiForm;


class ContabiForm {
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct($type=null)
    {
       $this->type = $type;
    }
	
	
	/**
     * Open form.
     *
     * @param  mixed  $method, $url
     * @return mixed
     */
	public function open($method, $url, $class = null){
				
		if($this->type == 'inline'){
			$class = ' row row-cols-lg-auto g-3 align-items-center ';
		}
		return view('contabiform.form-open',compact('url','class','method'));
	}
	
	
	/**
     * Close form.
     *
     * @return string
     */
	public function close(){
		
		return view('contabiform.form-close');
	}
	
	
	
	/**
     * Input form generico.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function input($item, $value,  $required=null, $lenght=null){
		
		$view = 'form-item-input';
		($lenght) ? $lenght : '3';
		
		return $this->item($view, $item, $value,  $required, $lenght);
	}
	
	
	/**
     * Input form data / bootstrap date picker.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function inputData($item, $value,  $required=null, $lenght=null){
		
		$view = 'form-item-input-data';
		($lenght) ? $lenght : '3';
		
		return $this->item($view, $item, $value,  $required, $lenght);
	}
	
	/**
     * Input form email.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function email($item, $value,  $required=null, $lenght=null){
		
		$view = 'form-item-input-email';
		($lenght) ? $lenght : '3';
		
		return $this->item($view, $item, $value,  $required, $lenght);
	}
	
	/**
     * Input form file.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function file($item, $value,  $required=null, $lenght=null){
		
		$view = 'form-item-input-file';
		($lenght) ? $lenght : '3';
				
		return $this->item($view, $item, $value,  $required, $lenght);
	}
	
	/**
     * Input form importo monetario.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function inputMoney($item, $value,  $required=null, $lenght=null){
		
		$view = 'form-item-input-money';
		($lenght) ? $lenght : '3';
		
		return $this->item($view, $item, $value,  $required, $lenght);
	}
	
	
	/**
     * Input form select.
     *
     * @param  mixed $item, $value,  $input_array, $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function select($item, $value, $old_value, $input_array, $required=null, $lenght=null){
		
		$view = 'form-item-input-select';
		($lenght) ? $lenght : '3';
		
		return view('contabiform.form-item-hidden',compact('item','value','old_value','required','lenght','input_array'));	
	}
	
	/**
     * TextArea.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function textarea($item, $value,  $required=null, $lenght=null){
		
		$view = 'form-item-textarea';
		($lenght) ? $lenght : '3';
				
		return $this->item($view, $item, $value,  $required, $lenght);
	}
	
	
	
	/**
     * Input form generico.
     *
     * @param  mixed $item, $value,  $required, $lenght
     * @return $this->item($view, $item, $value,  $required, $lenght)
     */
	public function hidden($name, $value){
		
		return view('contabiform.form-item-hidden',compact('name','value'));
	}
	
	/**
     * item view
     *
     * @param  mixed $view, $item, $value,  $required, $lenght, $input_array
     * @return string
     */
	
	public function item($view, $item, $value,  $required, $lenght, $input_array=null){
		
		if($this->type == 'inline'){			
			$div = 'col-12';
		}
		if($this->type == 'horizontal'){			
			$div = 'form-group col-md-'.$lenght;
		}
		if($this->type == 'row'){			
			$div = 'mb-3 col-md-'.$lenght;
		}
		
		return view('contabiform.form-item',compact('view','div','item','required','lenght','input_array'));
	}
	
	
	/**
     * div form row
     *
     * @param  void
     * @return string
     */
	
	public function row(){
		
		return view('contabiform.form-row-open');
	}
	
	/**
     * div form row close
     *
     * @param  void
     * @return string
     */
	public function rowclose(){
		
		return view('contabiform.form-row-close');
	}
	
	
	/**
     * form button
     *
     * @param  mixed $name, $color, $class
     * @return string
     */
	 
	public function button($name, $color, $class=null){
				
		if($this->type == 'inline'){
			$class = 'class="col-12"';
		}
				
		return view('contabiform.form-button',compact('class','name','color'));
	}
}
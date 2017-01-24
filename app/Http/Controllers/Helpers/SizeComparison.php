<?php namespace App\Http\Controllers\Helpers;

use APP;

/**
 * { SizeComparison Class }
 * @author Budi
 * 
 * public functions :
 * 1. isLarger() 							: public function to check is "$this_size" is larger than its "$equivalence"
 * 2. isSmaller() 							: public function to check is "$this_size" is smaller than its "$equivalence"
 * 
 * private functions :
 * 1. compareSize() 						: private function to compare given sizes
 * 2. detectAndConvertSize() 				: Since size has vary value (from number: 6,7,etc till text : S, M), so we need to convert size value in proper format to compare its value.
 */

class SizeComparison
{
	protected $operand1;
	protected $operand2;
	protected $operator;
	
	/**
	 * [Public] isLarger
	 *
	 * @param     
	 * 1. $this_size 				   		: current size which is going to compare with
	 * 2. $equivalence 						: value that this_size comparing to
	 *
	 * @return
	 * 1. Boolean 							: True or False
	 * 
	 * steps
	 * 1. Assign to this class parameter
	 * 2. Compare and return
	 */
	public function isLarger($this_size, $equivalence)
	{
		$this->operand1 				= $this_size;
		$this->operand2 				= $equivalence;
		$this->operator 				= '>';

		return $this->compareSize();
	}

	/**
	 * [Public] isSmaller
	 *
	 * @param     
	 * 1. $this_size 				   		: current size which is going to compare with
	 * 2. $equivalence 						: value that this_size comparing to
	 *
	 * @return
	 * 1. Boolean 							: True or False
	 * 
	 * steps
	 * 1. Assign to this class parameter
	 * 2. Compare and return
	 */
	public function isSmaller($this_size, $equivalence)
	{
		$this->operand1 				= $this_size;
		$this->operand2 				= $equivalence;
		$this->operator 				= '<';


		return $this->compareSize();
	}

	/**
	 * [Private] compareSize
	 *
	 * @param     
	 * _
	 *
	 * @return
	 * 1. Boolean 							: True or False
	 * 
	 * steps
	 * 1. Converting Size to proper format
	 * 2. Comparing and return
	 */
	Private function compareSize(){
		// is operands are text size base? convert when it is yes and leave it when it is not.
		$this->operand1 				= $this->detectAndConvertSize($this->operand1);
		$this->operand2 				= $this->detectAndConvertSize($this->operand2);

		// compare
		if($this->operator == '<'){
			if($this->operand1 < $this->operand2){
				return true;
			}else{
				return false;
			}
		}elseif($this->operator == '>'){
			if($this->operand1 > $this->operand2){
				return true;
			}else{
				return false;
			}
		}else{
			APP::abort(404, 'Undefinied Operator. Please check your function that call compareSize function.');
		}
	}

	/**
	 * [Private] detectAndConvertSize
	 *
	 * @param     
	 * 1. $operand 							: value to be converted
	 *
	 * @return
	 * 1. Boolean 							: True or False
	 * 
	 * steps
	 * 1. Check if value in Text Format
	 * 2. Return Result
	 */
	private function detectAndConvertSize($operand){
		// size array
		$size_text 					= ['xs', 's', 'm', 'l', 'xl', 'xxl'];
		
		//is value in array
		$result 					= array_search($operand, $size_text);

		//return
		if($result != false){
			return $result + 1;
		}else{
			return $operand;
		}
	}
}
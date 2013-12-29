<?php

	
	Class NumberToWords {
	
		private $ones    = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
		private $elevens = array('', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
		private $tens    = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
		
		
		
		private $nepaliNumbers = array(				
							3		=> 'hundred',
							4 		=> 'thousand',
							5 		=> 'thousand',
							6 		=> 'lakh',
							7 		=> 'lakh',
							8 		=> 'crore',
							9 		=> 'crore',
							10 		=> 'arab',
							11 		=> 'arab',
							12 		=> 'kharab',
							13 		=> 'kharab',
						);
						
		private $englishNumbers = array(				
							3		=> 'hundred',
							4 		=> 'thousand',
							5 		=> 'thousand',
							6 		=> 'thousand',
							7 		=> 'million',
							8 		=> 'million',
							9 		=> 'million',
							10 		=> 'billion',
							11 		=> 'billion',
							12 		=> 'billion',
							13 		=> 'trillion',
							14		=> 'trillion',
							15		=> 'trillion',
						);

		
		public function __construct() {
			
		}
		
		public function set_system($system) {
			$this->system = $system;
		}
								
		public function convert($number) {
		
			if ($this->system == 'english') {
				$this->lots = $this->englishNumbers;
			} elseif ($this->system == 'nepali'){
				$this->lots = $this->nepaliNumbers;
			} else {
				throw new Exception('Division by zero.'); 
			}
			
			if($number === 0) {
				return 'Zero';
			} elseif ($number <= 9) {		
				// 0 - 9
				return ucfirst($this->ones[intval($number)]);
			
			} elseif (($number >= 11) && ($number <= 19)) {		
				// 11 - 19
				return ucfirst($this->elevens[intval(($number % 10))]);
			
			} elseif (($number <= 90) && (($number % 10) == 0)) {	
				// 10, 20, 30, 40, 50, 60, 70, 80, 90
				return ucfirst($this->tens[intval(($number / 10))]);
			
			} elseif (($number >= 21) && ($number <= 99) && (!($number % 10) == 0)) {		
				// 21-99
				return ucfirst($this->tens[intval(substr($number, -2, 1))]) . ' ' . ucfirst($this->ones[intval(($number % 10))]);
			
			} elseif (($number % 100) == 0) {	
				
				if ((strlen($number) % 2 == 0) || (strlen($number) == 3)) {
				
					// Something like thousand, lakh...
					$divisor = '1'; for($i = 1; $i <= (strlen($number) - 1); $i++) $divisor .= '0';
					$tada = ucfirst($this->ones[intval($number/$divisor)]) . ' ' . ucfirst($this->lots[intval(log10($number) + 1)]);
					$number = substr($number, 1, (strlen($number) - 1));
					
				} elseif (strlen($number) % 2 == 1) {
				
					// Something like ten thousand, ten lakh...
					$divisor = '1'; for($i = 1; $i <= (strlen($number) - 2); $i++) $divisor .= '0';
					$tada = $this->convert($number/$divisor) . ' ' . ucfirst($this->lots[intval(log10($number) + 1)]);
					$number = substr($number, 2, (strlen($number) - 2));
					
				}
					
				$tada .= ' ' . $this->convert($number);
				
				return $tada;
				
			}
			elseif (($number > 100) && ( ! ($number % 100) == 0)) {
			
				if ((strlen($number) % 2 == 0) || (strlen($number) == 3)) {
				
					// Something like thousand, lakh...
					$replacement = 0; for($i = 1; $i < (strlen($number) - 1); $i++) $replacement .= '0';
					$words = $this->convert(substr_replace($number, $replacement, 1, (strlen($number) - 1)));
					$number = substr($number, 1, (strlen($number) - 1));
					
					
				} elseif (strlen($number) % 2 == 1) {
				
					// Something like ten thousand, ten lakh...
					$replacement = 0; for($i = 1; $i < (strlen($number) - 2); $i++) $replacement .= '0';
					$words = $this->convert(substr_replace($number, $replacement, 2, (strlen($number) - 2)));
					$number = substr($number, 2, (strlen($number) - 2));
					
				}
				
				$words .= ' ' . $this->convert($number);
				
				return $words;
			}
		}
	}
	


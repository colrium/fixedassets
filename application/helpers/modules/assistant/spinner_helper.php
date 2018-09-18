<?php
	function addenglishtextalternatives($text, $keeporiginals = TRUE){
		preg_match_all("/<[^<>]+>/is",$text,$matches,PREG_PATTERN_ORDER);
		$htmlfounds=$matches[0];

		$pattern="\[.*?\]";
		preg_match_all("/".$pattern."/s",$text,$matches2,PREG_PATTERN_ORDER);
		$shortcodes=$matches2[0];
		
		$htmlfounds=array_merge($htmlfounds,$shortcodes);
		
		
		foreach($htmlfounds as $htmlfound){
			$text=str_replace($htmlfound,'('.md5($htmlfound).')',$text);
		}

		$file = file(dirname(__FILE__)  .'/en_synonymous.data');
		$founds=array();
		$foundsindex = 0;
		foreach($file as $line){			
			$synonyms=explode('|',$line);
			foreach($synonyms as $word){
				if(trim($word) != ''){		
					$word=str_replace('/','\/',$word);
					
					if(preg_match('/\b'. $word .'\b/i', $text)) {
						if ($keeporiginals) {
							$wordpos = array_search($word, $synonyms);							
							unset($synonyms[$wordpos]);
							array_unshift($synonyms, $word);
							$newline = implode('|', $synonyms);
							$founds[md5($foundsindex)] = str_replace(array("\n", "\r"), '',$newline);
							$text = preg_replace('/\b'.$word.'\b/i', md5($foundsindex), $text);
						}
						else{
							$wordpos = array_search($word, $synonyms);
							unset($synonyms[$wordpos]);
							$newline = implode('|', $synonyms);
							$founds[md5($foundsindex)] = str_replace(array("\n", "\r"), '',$newline);
							$text = preg_replace('/\b'.$word.'\b/i', md5($foundsindex), $text);
						}

						$foundsindex++;
							
					  
					}
				}
			}
			
		}

		foreach ($founds as $key => $value) {
			$text = preg_replace('/\b'.$key.'\b/i', '{'.$value.'}', $text);
		}
		
		 return $text;		

	}
	function spinenglishtext($text){
        return preg_replace_callback('/\{(((?>[^\{\}]+)|(?R))*)\}/x', 
        	function ($text) {
        		$text = spinenglishtext($text[1]);
		        $parts = explode('|', $text);
		        return $parts[array_rand($parts)];
        	}, $text);
    }


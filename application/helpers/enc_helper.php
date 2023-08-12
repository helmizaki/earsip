<?php 
	//@ENC_DEC //////////////////////////////////////////////////////////////////////////////////
	function ENC($message) 
		{
			$key = md5("081298078787"); //Keynya nomor HP gw aja... Pusing nentuinnya
			
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
			$message_padded = mr_pad_with_zeros($message);
			$encrypted = openssl_encrypt($message_padded,'AES-256-CBC',$key,OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,$iv);
			return $iv.$encrypted;
		}

	function DEC($message) 
		{
			$key = md5("081298078787"); //Keynya nomor HP gw aja... Pusing nentuinnya
			
			$iv = substr($message,0,openssl_cipher_iv_length('AES-256-CBC'));
			$encrypted = substr($message,openssl_cipher_iv_length('AES-256-CBC'),strlen($message)-openssl_cipher_iv_length('AES-256-CBC'));
			$decrypted = openssl_decrypt($encrypted,'AES-256-CBC',$key,OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,$iv);
			return TRIM($decrypted);
		}
	
	function mr_pad_with_zeros($message) 
		{
			$padding = 16 - (strlen($message) % 16);
			$message_padded = $message.str_repeat(chr(0),$padding);
			return $message_padded;
		}
	//@ENC_DEC //////////////////////////////////////////////////////////////////////////////////
?>
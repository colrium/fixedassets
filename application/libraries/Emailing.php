<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*---------------------------------------------------------------------
FORT TECHNOLOGIES SYSTEM
Developed By Mutugi Riungu 2016
NO ALTERATIONS OR CODE REUSE IS AUTHORIZED     
---------------------------------------------------------------------*/

class Emailing{

	protected $SERVER_ERROR = 'Problem connecting to %s. Check server, port or ssl settings for your email server.';
	protected $LOGIN_ERROR = 'Your email provider has rejected your login information. Verify your email and/or password is correct.';
	protected $TLS_ERROR = 'Problem connecting to %s with TLS on.';
	protected $SMTP_ADD_EMAIL = 'Adding %s to email failed.';
	protected $SMTP_DATA = 'Server did not allow data to be added.';


	//IMAP Variables
	protected $imap_timeout = 300;
	protected $imap_no_subject = '(no subject)';
	protected $imap_host = null;
	protected $imap_port = null;
	protected $imap_ssl = false;
	protected $imap_tls = false;
	protected $imap_username = null;
	protected $imap_password = null;
	protected $imap_tag = 0;
	protected $imap_total = 0;
	protected $imap_next = 0;
	protected $imap_buffer = null;
	protected $imap_socket = null;
	protected $imap_mailbox = null;
	protected $imap_mailboxtotal = null;
	protected $imap_mailboxes = array();
	private $imap_debugging = false;
	private $imap_initialized = false;


	//SMTP Variables
	protected $smtp_timeout = 300;
	protected $smtp_host = null;
	protected $smtp_port = null;
	protected $smtp_ssl = false;
	protected $smtp_tls = false;
	protected $smtp_username = null;
	protected $smtp_password = null;
	protected $smtp_socket = null;
	protected $smtp_boundary = array();
	protected $smtp_subject  = null;
	protected $smtp_body = array();
	protected $smtp_to = array();
	protected $smtp_cc = array();
	protected $smtp_bcc = array();
	protected $smtp_attachments = array();
	private $smtp_debugging = false;



	//POP3 Variables    
	protected $pop3_timeout = 30;
	protected $pop3_no_subject = '(no subject)';
	protected $pop3_host = null;
	protected $pop3_port = null;
	protected $pop3_ssl = false;
	protected $pop3_tls = false;
	protected $pop3_username = null;
	protected $pop3_password = null;
	protected $pop3_timestamp = null;
	protected $pop3_socket = null;
	protected $pop3_loggedin = false;
	private $pop3_debugging = false;





	public function __construct(){


	}



	public function exception($message, $variable=''){
		$message = str_replace('%s', $variable, $message);
		show_error($message, 500);
	}






	/**
	 * POP3 FUNCTIONS
	 */
	public function pop3_init($host, $user, $pass, $port = null, $ssl = false, $tls = false){
		if (is_null($port)) {
			$port = $ssl ? 465 : 25;
		}
		$this->pop3_host = $host;
		$this->pop3_username = $user;
		$this->pop3_password = $pass;
		$this->pop3_port = $port;
		$this->pop3_ssl = $ssl;
		$this->pop3_tls = $tls;
	}

	public function pop3_connect($test = false){
		if ($this->pop3_loggedin) {
			
		}

		$host = $this->pop3_host;

		if ($this->pop3_ssl) {
			$host = 'ssl://' . $host;
		}

		$errno  =  0;
		$errstr = '';

		$this->pop3_socket = fsockopen($host, $this->pop3_port, $errno, $errstr, $this->pop3_timeout);

		if (!$this->pop3_socket) {
			//throw exception
			$this->exception($this->SERVER_ERROR, $host.':'.$this->pop3_port);
		}

		$welcome = $this->pop3_receive();

		strtok($welcome, '<');
		$this->pop3_timestamp = strtok('>');
		if (!strpos($this->pop3_timestamp, '@')) {
			$this->pop3_timestamp = null;
		} else {
			$this->pop3_timestamp = '<' . $this->pop3_timestamp . '>';
		}

		if ($this->pop3_tls) {
			$this->pop3_call('STLS');
			if (!stream_socket_enable_crypto(
				$this->pop3_socket,
				true,
				STREAM_CRYPTO_METHOD_TLS_CLIENT
			)) {
				$this->pop3_disconnect();
				//throw exception
				$this->exception($this->TLS_ERROR, $host.':'.$this->pop3_port);
			}
		}

		if ($test) {
			$this->pop3_disconnect();
			
		}

		//login
		if ($this->pop3_timestamp) {
			try {
				$this->pop3_call('APOP '.$this->pop3_username. ' '. md5($this->pop3_timestamp . $this->pop3_password)
				);
				return;
			} catch (Argument $e) {
				// ignore
			}
		}

		$this->pop3_call('USER '.$this->pop3_username);
		$this->pop3_call('PASS '.$this->pop3_password);

		$this->pop3_loggedin = true;

		
	}


	public function pop3_disconnect(){
		if (!$this->pop3_socket) {
			
		}

		try {
			$this->pop3_send('QUIT');
		} catch (Argument $e) {
			// ignore error - we're closing the socket anyway
		}

		fclose($this->pop3_socket);
		$this->pop3_socket = null;

		
	}


	public function pop3_getEmails($start = 0, $range = 10){
		$total = $this->pop3_getEmailTotal();

		if ($total == 0) {
			return array();
		}

		if (!is_array($start)) {
			$range = $range > 0 ? $range : 1;
			$start = $start >= 0 ? $start : 0;
			$max = $total - $start;

			if ($max < 1) {
				$max = $total;
			}

			$min = $max - $range + 1;

			if ($min < 1) {
				$min = 1;
			}

			$set = $min . ':' . $max;

			if ($min == $max) {
				$set = $min;
			}
		}

		$emails = array();
		for ($i = $min; $i <= $max; $i++) {
			$emails[] = $this->pop3_getEmailFormat($this->pop3_call('RETR '.$i, true));
		}

		return $emails;
	}

	public function pop3_getEmailTotal(){
		@list($messages, $octets) = explode(' ', $this->pop3_call('STAT'));
		$messages = is_numeric($messages) ? $messages : 0;

		return $messages;
	}


	public function pop3_remove($msgno){

		$this->pop3_call("DELE $msgno");

		if (!$this->pop3_loggedin || !$this->pop3_socket) {
			return false;
		}

		if (!is_array($msgno)) {
			$msgno = array($msgno);
		}

		foreach ($msgno as $number) {
			$this->pop3_call('DELE '.$number);
		}

		
	}


	protected function pop3_call($command, $multiline = false){
		if (!$this->pop3_send($command)) {
			return false;
		}

		return $this->pop3_receive($multiline);
	}


	protected function pop3_receive($multiline = false){
		$result = @fgets($this->pop3_socket);
		$status = $result = trim($result);
		$message = '';

		if (strpos($result, ' ')) {
			list($status, $message) = explode(' ', $result, 2);
		}

		if ($status != '+OK') {
			return false;
		}

		if ($multiline) {
			$message = '';
			$line = fgets($this->pop3_socket);
			while ($line && rtrim($line, "\r\n") != '.') {
				if ($line[0] == '.') {
					$line = substr($line, 1);
				}
				$this->pop3_debug('Receiving: '.$line);
				$message .= $line;
				$line = fgets($this->pop3_socket);
			};
		}

		return $message;
	}


	protected function pop3_send($command){
		$this->pop3_debug('Sending: '.$command);

		return fputs($this->pop3_socket, $command . "\r\n");
	}


	private function pop3_debug($string){
		if ($this->pop3_debugging) {
			$string = htmlspecialchars($string);


			echo '<pre>'.$string.'</pre>'."\n";
		}
		
	}


	private function pop3_getEmailFormat($email, array $flags = array()){
		//if email is an array
		if (is_array($email)) {
			//make it into a string
			$email = implode("\n", $email);
		}

		//split the head and the body
		$parts = preg_split("/\n\s*\n/", $email, 2);

		$head = $parts[0];
		$body = null;
		if (isset($parts[1]) && trim($parts[1]) != ')') {
			$body = $parts[1];
		}

		$lines = explode("\n", $head);
		$head = array();
		foreach ($lines as $line) {
			if (trim($line) && preg_match("/^\s+/", $line)) {
				$head[count($head)-1] .= ' '.trim($line);
				continue;
			}

			$head[] = trim($line);
		}

		$head = implode("\n", $head);

		$recipientsTo = $recipientsCc = $recipientsBcc = $sender = array();

		//get the headers
		$headers1   = imap_rfc822_parse_headers($head);
		$headers2   = $this->pop3_getHeaders($head);

		//set the from
		$sender['name'] = null;
		if (isset($headers1->from[0]->personal)) {
			$sender['name'] = $headers1->from[0]->personal;
			//if the name is iso or utf encoded
			if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($sender['name']))) {
				//decode the subject
				$sender['name'] = str_replace('_', ' ', mb_decode_mimeheader($sender['name']));
			}
		}

		$sender['email'] = $headers1->from[0]->mailbox . '@' . $headers1->from[0]->host;

		//set the to
		if (isset($headers1->to)) {
			foreach ($headers1->to as $to) {
				if (!isset($to->mailbox, $to->host)) {
					continue;
				}

				$recipient = array('name'=>null);
				if (isset($to->personal)) {
					$recipient['name'] = $to->personal;
					//if the name is iso or utf encoded
					if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}

				$recipient['email'] = $to->mailbox . '@' . $to->host;

				$recipientsTo[] = $recipient;
			}
		}

		//set the cc
		if (isset($headers1->cc)) {
			foreach ($headers1->cc as $cc) {
				$recipient = array('name'=>null);
				if (isset($cc->personal)) {
					$recipient['name'] = $cc->personal;

					//if the name is iso or utf encoded
					if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}

				$recipient['email'] = $cc->mailbox . '@' . $cc->host;

				$recipientsCc[] = $recipient;
			}
		}

		//set the bcc
		if (isset($headers1->bcc)) {
			foreach ($headers1->bcc as $bcc) {
				$recipient = array('name'=>null);
				if (isset($bcc->personal)) {
					$recipient['name'] = $bcc->personal;
					//if the name is iso or utf encoded
					if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}

				$recipient['email'] = $bcc->mailbox . '@' . $bcc->host;

				$recipientsBcc[] = $recipient;
			}
		}

		//if subject is not set
		if (!isset($headers1->subject) || strlen(trim($headers1->subject)) === 0) {
			//set subject
			$headers1->subject = $this->pop3_no_subject;
		}

		//trim the subject
		$headers1->subject = str_replace(array('<', '>'), '', trim($headers1->subject));

		//if the subject is iso or utf encoded
		if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($headers1->subject))) {
			//decode the subject
			$headers1->subject = str_replace('_', ' ', mb_decode_mimeheader($headers1->subject));
		}

		//set thread details
		$topic  = isset($headers2['thread-topic']) ? $headers2['thread-topic'] : $headers1->subject;
		$parent = isset($headers2['in-reply-to']) ? str_replace('"', '', $headers2['in-reply-to']) : null;

		//set date
		$date = isset($headers1->date) ? strtotime($headers1->date) : null;

		//set message id
		if (isset($headers2['message-id'])) {
			$messageId = str_replace('"', '', $headers2['message-id']);
		} else {
			$messageId = '<eden-no-id-'.md5(uniqid()).'>';
		}

		$attachment = isset($headers2['content-type'])
			&& strpos($headers2['content-type'], 'multipart/mixed') === 0;

		$format = array(
			'id'            => $messageId,
			'parent'        => $parent,
			'topic'         => $topic,
			'mailbox'       => 'INBOX',
			'date'          => $date,
			'subject'       => str_replace('’', '\'', $headers1->subject),
			'from'          => $sender,
			'flags'         => $flags,
			'to'            => $recipientsTo,
			'cc'            => $recipientsCc,
			'bcc'           => $recipientsBcc,
			'attachment'    => $attachment);

		if (trim($body) && $body != ')') {
			//get the body parts
			$parts = $this->pop3_getParts($email);

			//if there are no parts
			if (empty($parts)) {
				//just make the body as a single part
				$parts = array('text/plain' => $body);
			}

			//set body to the body parts
			$body = $parts;

			//look for attachments
			$attachment = array();
			//if there is an attachment in the body
			if (isset($body['attachment'])) {
				//take it out
				$attachment = $body['attachment'];
				unset($body['attachment']);
			}

			$format['body']         = $body;
			$format['attachment']   = $attachment;
		}

		return $format;
	}


	private function pop3_getHeaders($rawData){
		if (is_string($rawData)) {
			$rawData = explode("\n", $rawData);
		}

		$key = null;
		$headers = array();
		foreach ($rawData as $line) {
			$line = trim($line);
			if (preg_match("/^([a-zA-Z0-9-]+):/i", $line, $matches)) {
				$key = strtolower($matches[1]);
				if (isset($headers[$key])) {
					if (!is_array($headers[$key])) {
						$headers[$key] = array($headers[$key]);
					}

					$headers[$key][] = trim(str_replace($matches[0], '', $line));
					continue;
				}

				$headers[$key] = trim(str_replace($matches[0], '', $line));
				continue;
			}

			if (!is_null($key) && isset($headers[$key])) {
				if (is_array($headers[$key])) {
					$headers[$key][count($headers[$key])-1] .= ' '.$line;
					continue;
				}

				$headers[$key] .= ' '.$line;
			}
		}

		return $headers;
	}


	private function pop3_getParts($content, array $parts = array()){
		//separate the head and the body
		list($head, $body) = preg_split("/\n\s*\n/", $content, 2);
		//get the headers
		$head = $this->pop3_getHeaders($head);
		//if content type is not set
		if (!isset($head['content-type'])) {
			return $parts;
		}

		//split the content type
		if (is_array($head['content-type'])) {
			$type = array($head['content-type'][1]);
			if (strpos($type[0], ';') !== false) {
				$type = explode(';', $type[0], 2);
			}
		} else {
			$type = explode(';', $head['content-type'], 2);
		}

		//see if there are any extra stuff
		$extra = array();
		if (count($type) == 2) {
			$extra = explode('; ', str_replace(array('"', "'"), '', trim($type[1])));
		}

		//the content type is the first part of this
		$type = trim($type[0]);


		//foreach extra
		foreach ($extra as $i => $attr) {
			//transform the extra array to a key value pair
			$attr = explode('=', $attr, 2);
			if (count($attr) > 1) {
				list($key, $value) = $attr;
				$extra[strtolower($key)] = $value;
			}
			unset($extra[$i]);
		}

		//if a boundary is set
		if (isset($extra['boundary'])) {
			//split the body into sections
			$sections = explode('--'.str_replace(array('"', "'"), '', $extra['boundary']), $body);
			//we only want what's in the middle of these sections
			array_pop($sections);
			array_shift($sections);

			//foreach section
			foreach ($sections as $section) {
				//get the parts of that
				$parts = $this->pop3_getParts($section, $parts);
			}
		} else {
			//if name is set, it's an attachment
			//if encoding is set
			if (isset($head['content-transfer-encoding'])) {
				//the goal here is to make everytihg utf-8 standard
				switch (strtolower($head['content-transfer-encoding'])) {
					case 'binary':
						$body = imap_binary($body);
						break;
					case 'base64':
						$body = base64_decode($body);
						break;
					case 'quoted-printable':
						$body = quoted_printable_decode($body);
						break;
					case '7bit':
						$body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
						break;
					default:
						$body = str_replace(array("\n", ' '), '', $body);
						break;
				}
			}

			if (isset($extra['name'])) {
				//add to parts
				$parts['attachment'][$extra['name']][$type] = $body;
			} else {
				//it's just a regular body
				//add to parts
				$parts[$type] = $body;
			}
		}
		return $parts;
	}










































	/**
	 * SMTP FUNCTIONS
	 */
	public function smtp_init($host, $user, $pass, $port = null, $ssl = false, $tls = false){
		if (is_null($port)) {
			$port = $ssl ? 465 : 25;
		}
		$this->smtp_host = $host;
		$this->smtp_username = $user;
		$this->smtp_password = $pass;
		$this->smtp_port = $port;
		$this->smtp_ssl = $ssl;
		$this->smtp_tls = $tls;
	}
	public function smtp_addAttachment($filename, $data, $mime = null){
		$this->smtp_attachments[] = array($filename, $data, $mime);
		
	}

	public function smtp_addBCC($email, $name = null){
		$this->smtp_bcc[$email] = $name;
		
	}
	public function smtp_addCC($email, $name = null){
		$this->smtp_cc[$email] = $name;
		
	}
	public function smtp_addTo($email, $name = null){
		$this->smtp_to[$email] = $name;
		
	}
	public function smtp_connect($timeout = false, $test = false){
		if ($timeout == false) {
			$timeout = $this->smtp_timeout;
		}
		$host = $this->smtp_host;

		if ($this->smtp_ssl) {
			$host = 'ssl://' . $host;
		} else {
			$host = 'tcp://' . $host;
		}

		$errno  =  0;
		$errstr = '';
		$this->smtp_socket = @stream_socket_client($host.':'.$this->smtp_port, $errno, $errstr, $timeout);

		if (!$this->smtp_socket || strlen($errstr) > 0 || $errno > 0) {
			//throw exception
			$this->exception($this->SERVER_ERROR, $host.':'.$this->smtp_port);
		}

		$this->smtp_receive();

		if (!$this->smtp_call('EHLO '.$_SERVER['HTTP_HOST'], 250)
		&& !$this->smtp_call('HELO '.$_SERVER['HTTP_HOST'], 250)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SERVER_ERROR, $host.':'.$this->smtp_port);
		}

		if ($this->smtp_tls && !$this->smtp_call('STARTTLS', 220, 250)) {
			if (!stream_socket_enable_crypto($this->smtp_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->TLS_ERROR, $host.':'.$this->smtp_port);
			}

			if (!$this->smtp_call('EHLO '.$_SERVER['HTTP_HOST'], 250)
			&& !$this->smtp_call('HELO '.$_SERVER['HTTP_HOST'], 250)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SERVER_ERROR, $host.':'.$this->smtp_port);
			}
		}

		if ($test) {
			$this->smtp_disconnect();
			
		}

		//login
		if (!$this->smtp_call('AUTH LOGIN', 250, 334)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->LOGIN_ERROR);
		}

		if (!$this->smtp_call(base64_encode($this->smtp_username), 334)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->LOGIN_ERROR);
		}

		if (!$this->smtp_call(base64_encode($this->smtp_password), 235, 334)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->LOGIN_ERROR);
		}

		
	}

	public function smtp_disconnect(){
		if ($this->smtp_socket) {
			$this->smtp_push('QUIT');
			fclose($this->smtp_socket);
			$this->smtp_socket = null;
		}
		
	}

	public function smtp_reply($messageId, $topic = null, array $headers = array()){
		//if no socket
		if (!$this->smtp_socket) {
			//then connect
			$this->smtp_connect();
		}

		//add from
		if (!$this->smtp_call('MAIL FROM:<' . $this->smtp_username . '>', 250, 251)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SMTP_ADD_EMAIL, $this->smtp_username);
		}

		//add to
		foreach ($this->smtp_to as $email => $name) {
			if (!$this->smtp_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SMTP_ADD_EMAIL, $email);
			}
		}

		//add cc
		foreach ($this->smtp_cc as $email => $name) {
			if (!$this->smtp_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SMTP_ADD_EMAIL, $email);
			}
		}

		//add bcc
		foreach ($this->smtp_bcc as $email => $name) {
			if (!$this->smtp_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SMTP_ADD_EMAIL, $email);
			}
		}

		//start compose
		if (!$this->smtp_call('DATA', 354)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SMTP_DATA);
		}

		$headers    = $this->smtp_getHeaders($headers);
		$body       = $this->smtp_getBody();

		$headers['In-Reply-To'] = $messageId;

		if ($topic) {
			$headers['Thread-Topic'] = $topic;
		}

		//send header data
		foreach ($headers as $name => $value) {
			var_dump($name.': '.$value);
			$this->smtp_push($name.': '.$value);
		}

		//send body data
		foreach ($body as $line) {
			if (strpos($line, '.') === 0) {
				// Escape lines prefixed with a '.'
				$line = '.' . $line;
			}

			$this->smtp_push($line);
		}

		//tell server this is the end
		if (!$this->smtp_call("\r\n.\r\n", 250)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SMTP_DATA);
		}

		//reset (some reason without this, this class spazzes out)
		$this->smtp_push('RSET');

		return $headers;
	}

	public function smtp_reset(){
		$this->smtp_subject      = null;
		$this->smtp_body     = array();
		$this->smtp_to           = array();
		$this->smtp_cc           = array();
		$this->smtp_bcc      = array();
		$this->smtp_attachments = array();
		$this->smtp_disconnect();
	}

	public function smtp_send(array $headers = array()){
		//if no socket
		if (!$this->smtp_socket) {
			//then connect
			$this->smtp_connect();
		}

		$headers    = $this->smtp_getHeaders($headers);
		$body       = $this->smtp_getBody();

		//add from
		if (!$this->smtp_call('MAIL FROM:<' . $this->smtp_username . '>', 250, 251)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SMTP_ADD_EMAIL, $this->smtp_username);
		}

		//add to
		foreach ($this->smtp_to as $email => $name) {
			if (!$this->smtp_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SMTP_ADD_EMAIL, $email);
			}
		}

		//add cc
		foreach ($this->smtp_cc as $email => $name) {
			if (!$this->smtp_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SMTP_ADD_EMAIL, $email);
			}
		}

		//add bcc
		foreach ($this->smtp_bcc as $email => $name) {
			if (!$this->smtp_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->smtp_disconnect();
				//throw exception
				$this->exception($this->SMTP_ADD_EMAIL, $email);
			}
		}

		//start compose
		if (!$this->smtp_call('DATA', 354)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SMTP_DATA);
		}

		//send header data
		foreach ($headers as $name => $value) {
			$this->smtp_push($name.': '.$value);
		}

		//send body data
		foreach ($body as $line) {
			if (strpos($line, '.') === 0) {
				// Escape lines prefixed with a '.'
				$line = '.' . $line;
			}

			$this->smtp_push($line);
		}

		//tell server this is the end
		if (!$this->smtp_call(".", 250)) {
			$this->smtp_disconnect();
			//throw exception
			$this->exception($this->SMTP_DATA);
		}

		//reset (some reason without this, this class spazzes out)
		$this->smtp_push('RSET');

		return $headers;
	}

	public function smtp_setBody($body, $html = false){
		if ($html) {
			$this->smtp_body['text/html'] = $body;
			$body = strip_tags($body);
		}

		$this->smtp_body['text/plain'] = $body;

		
	}

	public function smtp_setSubject($subject){
		$this->smtp_subject = $subject;
		
	}


	protected function smtp_addAttachmentBody(array $body){
		foreach ($this->smtp_attachments as $attachment) {
			list($name, $data, $mime) = $attachment;
			$mime   = $mime ? $mime : File::i($name)->getMime();
			$data   = base64_encode($data);
			$count  = ceil(strlen($data) / 998);

			$body[] = '--'.$this->smtp_boundary[1];
			$body[] = 'Content-type: '.$mime.'; name="'.$name.'"';
			$body[] = 'Content-disposition: attachment; filename="'.$name.'"';
			$body[] = 'Content-transfer-encoding: base64';
			$body[] = null;

			for ($i = 0; $i < $count; $i++) {
				$body[] = substr($data, ($i * 998), 998);
			}

			$body[] = null;
			$body[] = null;
		}
		$body[] = '--'.$this->smtp_boundary[1].'--';
		return $body;
	}

	protected function smtp_call($command, $code = null){
		if (!$this->smtp_push($command)) {
			return false;
		}
		$receive = $this->smtp_receive();
		$args = func_get_args();
		if (count($args) > 1) {
			for ($i = 1; $i < count($args); $i++) {
				if (strpos($receive, (string)$args[$i]) === 0) {
					return true;
				}
			}

			return false;
		}
		return $receive;
	}

	protected function smtp_getAlternativeAttachmentBody(){
		$alternative    = $this->smtp_getAlternativeBody();

		$body = array();
		$body[] = 'Content-Type: multipart/mixed; boundary="'.$this->smtp_boundary[1].'"';
		$body[] = null;
		$body[] = '--'.$this->smtp_boundary[1];
		foreach ($alternative as $line) {
			$body[] = $line;
		}
		return $this->smtp_addAttachmentBody($body);
	}


	protected function smtp_getAlternativeBody(){
		$plain  = $this->smtp_getPlainBody();
		$html   = $this->smtp_getHtmlBody();

		$body   = array();
		$body[] = 'Content-Type: multipart/alternative; boundary="'.$this->smtp_boundary[0].'"';
		$body[] = null;
		$body[] = '--'.$this->smtp_boundary[0];

		foreach ($plain as $line) {
			$body[] = $line;
		}

		$body[] = '--'.$this->smtp_boundary[0];

		foreach ($html as $line) {
			$body[] = $line;
		}

		$body[] = '--'.$this->smtp_boundary[0].'--';
		$body[] = null;
		$body[] = null;

		return $body;
	}


	protected function smtp_getBody(){
		$type = 'Plain';
		if (count($this->smtp_body) > 1) {
			$type = 'Alternative';
		} else if (isset($this->smtp_body['text/html'])) {
			$type = 'Html';
		}

		$method = 'get%sBody';
		if (!empty($this->smtp_attachments)) {
			$method = 'get%sAttachmentBody';
		}

		$method = sprintf($method, $type);
		return $this->smtp_getHtmlBody();
	}


	protected function smtp_getHeaders(array $customHeaders = array()){
		$timestamp = $this->smtp_getTimestamp();

		$subject = trim($this->smtp_subject);
		$subject = str_replace(array("\n", "\r"), '', $subject);

		$to = $cc = $bcc = array();
		foreach ($this->smtp_to as $email => $name) {
			$to[] = trim($name.' <'.$email.'>');
		}

		foreach ($this->smtp_cc as $email => $name) {
			$cc[] = trim($name.' <'.$email.'>');
		}

		foreach ($this->smtp_bcc as $email => $name) {
			$bcc[] = trim($name.' <'.$email.'>');
		}

		list($account, $suffix) = explode('@', $this->smtp_username);

		$headers = array(
			'Date'          => $timestamp,
			'Subject'       => $subject,
			'From'          => '<'.$this->smtp_username.'>',
			'To'            => implode(', ', $to));

		if (!empty($cc)) {
			$headers['Cc'] = implode(', ', $cc);
		}

		if (!empty($bcc)) {
			$headers['Bcc'] = implode(', ', $bcc);
		}

		$headers['Message-ID']  = '<'.md5(uniqid(time())).'.eden@'.$suffix.'>';

		$headers['Thread-Topic'] = $this->smtp_subject;

		$headers['Reply-To'] = '<'.$this->smtp_username.'>';

		foreach ($customHeaders as $key => $value) {
			$headers[$key] = $value;
		}

		return $headers;
	}

	
	protected function smtp_getHtmlAttachmentBody(){
		$html   = $this->smtp_getHtmlBody();
		$body = array();
		$body[] = 'Content-Type: multipart/mixed; boundary="'.$this->smtp_boundary[1].'"';
		$body[] = null;
		$body[] = '--'.$this->smtp_boundary[1];

		foreach ($html as $line) {
			$body[] = $line;
		}

		return $this->smtp_addAttachmentBody($body);
	}


	protected function smtp_getHtmlBody(){
		$charset    = $this->smtp_isUtf8($this->smtp_body['text/html']) ? 'utf-8' : 'US-ASCII';
		$html       = str_replace("\r", '', trim($this->smtp_body['text/html']));

		$encoded = explode("\n", $this->smtp_quotedPrintableEncode($html));
		$body   = array();
		$body[] = 'Content-Type: text/html; charset='.$charset;
		$body[] = 'Content-Transfer-Encoding: quoted-printable'."\n";
		foreach ($encoded as $line) {
			$body[] = $line;
		}
		$body[] = null;
		$body[] = null;
		return $body;
	}


	protected function smtp_getPlainAttachmentBody(){
		$plain  = $this->smtp_getPlainBody();

		$body = array();
		$body[] = 'Content-Type: multipart/mixed; boundary="'.$this->smtp_boundary[1].'"';
		$body[] = null;
		$body[] = '--'.$this->smtp_boundary[1];

		foreach ($plain as $line) {
			$body[] = $line;
		}

		return $this->smtp_addAttachmentBody($body);
	}


	protected function smtp_getPlainBody(){
		$charset    = $this->smtp_isUtf8($this->smtp_body['text/plain']) ? 'utf-8' : 'US-ASCII';
		$plane      = str_replace("\r", '', trim($this->smtp_body['text/plain']));
		$count      = ceil(strlen($plane) / 998);

		$body = array();
		$body[] = 'Content-Type: text/plain; charset='.$charset;
		$body[] = 'Content-Transfer-Encoding: 7bit';
		$body[] = null;

		for ($i = 0; $i < $count; $i++) {
			$body[] = substr($plane, ($i * 998), 998);
		}

		$body[] = null;
		$body[] = null;

		return $body;
	}


	protected function smtp_receive(){
		$data = '';
		$now = time();

		while ($str = fgets($this->smtp_socket, 1024)) {
			$data .= $str;

			if (substr($str, 3, 1) == ' ' || time() > ($now + $this->smtp_timeout)) {
				break;
			}
		}
		$this->smtp_debug('Receiving: '. $data);
		return $data;
	}


	protected function smtp_push($command){
		$this->smtp_debug('Sending: '.$command);

		return fwrite($this->smtp_socket, $command . "\r\n");
	}


	private function smtp_debug($string){
		if ($this->smtp_debugging) {
			$string = htmlspecialchars($string);
			echo '<pre>'.$string.'</pre>'."\n";
		}

		
	}
	private function smtp_getTimestamp(){
		$zone = date('Z');
		$sign = ($zone < 0) ? '-' : '+';
		$zone = abs($zone);
		$zone = (int)($zone / 3600) * 100 + ($zone % 3600) / 60;
		return sprintf("%s %s%04d", date('D, j M Y H:i:s'), $sign, $zone);
	}


	private function smtp_isUtf8($string){
		$regex = array(
			'[\xC2-\xDF][\x80-\xBF]',
			'\xE0[\xA0-\xBF][\x80-\xBF]',
			'[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}',
			'\xED[\x80-\x9F][\x80-\xBF]',
			'\xF0[\x90-\xBF][\x80-\xBF]{2}',
			'[\xF1-\xF3][\x80-\xBF]{3}',
			'\xF4[\x80-\x8F][\x80-\xBF]{2}');

		$count = ceil(strlen($string) / 5000);
		for ($i = 0; $i < $count; $i++) {
			if (preg_match('%(?:'. implode('|', $regex).')+%xs', substr($string, ($i * 5000), 5000))) {
				return false;
			}
		}
		return true;
	}


	private function smtp_quotedPrintableEncode($input, $line_max = 250){
		$hex = array('0','1','2','3','4','5','6','7',
							  '8','9','A','B','C','D','E','F');
		$lines = preg_split("/(?:\r\n|\r|\n)/", $input);
		$linebreak = "=0D=0A=\r\n";
		/* the linebreak also counts as characters in the mime_qp_long_line
		* rule of spam-assassin */
		$line_max = $line_max - strlen($linebreak);
		$escape = "=";
		$output = "";
		$cur_conv_line = "";
		$length = 0;
		$whitespace_pos = 0;
		$addtl_chars = 0;

		// iterate lines
		for ($j = 0; $j < count($lines); $j++) {
			$line = $lines[$j];
			$linlen = strlen($line);

			// iterate chars
			for ($i = 0; $i < $linlen; $i++) {
				$c = substr($line, $i, 1);
				$dec = ord($c);

				$length++;

				if ($dec == 32) {
					// space occurring at end of line, need to encode
					if (($i == ($linlen - 1))) {
						$c = "=20";
						$length += 2;
					}

					$addtl_chars = 0;
					$whitespace_pos = $i;
				} else if (($dec == 61) || ($dec < 32 ) || ($dec > 126)) {
					  $h2 = floor($dec/16);
					  $h1 = floor($dec%16);
					  $c = $escape . $hex["$h2"] . $hex["$h1"];
					  $length += 2;
					  $addtl_chars += 2;
				}

				// length for wordwrap exceeded, get a newline into the text
				if ($length >= $line_max) {
					$cur_conv_line .= $c;

					// read only up to the whitespace for the current line
					$whitesp_diff = $i - $whitespace_pos + $addtl_chars;

					//the text after the whitespace will have to be read
					// again ( + any additional characters that came into
					// existence as a result of the encoding process after the whitespace)
					//
					// Also, do not start at 0, if there was *no* whitespace in
					// the whole line
					if (($i + $addtl_chars) > $whitesp_diff) {
						$output .= substr($cur_conv_line, 0, (strlen($cur_conv_line) -
								$whitesp_diff)) . $linebreak;
						$i =  $i - $whitesp_diff + $addtl_chars;
					} else {
						$output .= $cur_conv_line . $linebreak;
					}

					$cur_conv_line = "";
					$length = 0;
					$whitespace_pos = 0;
				} else {
					// length for wordwrap not reached, continue reading
					$cur_conv_line .= $c;
				}
			} // end of for

			$length = 0;
			$whitespace_pos = 0;
			$output .= $cur_conv_line;
			$cur_conv_line = "";

			if ($j<=count($lines)-1) {
				$output .= $linebreak;
			}
		} // end for

		return trim($output);
	}





















































	/**
	 * IMAP FUNCTIONS
	 */
	public function imap_init($host, $user, $pass, $port = null, $ssl = false, $tls = false){
		if (is_null($port)) {
			$port = $ssl ? 993 : 143;
		}
		$this->imap_host = $host;
		$this->imap_username = $user;
		$this->imap_password = $pass;
		$this->imap_port = $port;
		$this->imap_ssl = $ssl;
		$this->imap_tls = $tls;


	}
	public function imap_connect($timeout = false, $test = false){
		if ($this->imap_socket) {
			return true;
		}
		if ($timeout == false) {
			$timeout = $this->imap_timeout;
		}
		$host = $this->imap_host;

		if ($this->imap_ssl) {
			$host = 'ssl://' . $host;
		}

		$errno  =  0;
		$errstr = '';

		$this->imap_socket = @fsockopen($host, $this->imap_port, $errno, $errstr, $timeout);
		

		if (!$this->imap_socket) {
			//throw exception
			$this->exception($this->SERVER_ERROR, $host.':'.$this->imap_port);
			return FALSE;
		}


		if (strpos($this->imap_getLine(), '* OK') === false) {
			$this->imap_disconnect();
			//throw exception
			$this->exception($this->SERVER_ERROR, $host.':'.$this->imap_port);
			return FALSE;
		}

		if ($this->imap_tls) {
			$this->imap_send('STARTTLS');
			if (!stream_socket_enable_crypto($this->imap_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
				$this->imap_disconnect();
				//throw exception
				$this->exception($this->TLS_ERROR, $host.':'.$this->imap_port);
				return FALSE;
			}
		}

		if ($test) {
			fclose($this->imap_socket);
			$this->imap_socket = null;
			
		}

		//login
		$result = $this->imap_call('LOGIN', $this->imap_escape($this->imap_username, $this->imap_password));

		if (!is_array($result) || strpos(implode(' ', $result), 'OK') === false) {
			$this->imap_disconnect();
			//throw exception
			$this->exception($this->LOGIN_ERROR);
			return FALSE;
		}

		return TRUE;

		
	}

	public function imap_disconnect(){
		if ($this->imap_socket) {
			$this->imap_send('LOGOUT');
			fclose($this->imap_socket);
			$this->imap_socket = null;
		}

		
	}

	public function imap_getActiveMailbox(){
		return $this->imap_mailbox;
	}

	public function imap_getUnseenEmails(){
		
	}

	public function imap_getEmails($start = 0, $range = 10, $body = false){
		//if not connected
		if (!$this->imap_socket) {
			//then connect
			$this->imap_connect();
		}

		//if the total in this mailbox is 0
		//it means they probably didn't select a mailbox
		//or the mailbox selected is empty
		if ($this->imap_total == 0) {
			//we might as well return an empty array
			return array();
		}

		//if start is an array
		if (is_array($start)) {
			//it is a set of numbers
			$set = implode(',', $start);
			//just ignore the range parameter
		} else {
			//start is a number
			//range must be grater than 0
			$range = $range > 0 ? $range : 1;
			//start must be a positive number
			$start = $start >= 0 ? $start : 0;

			//calculate max (ex. 300 - 4 = 296)
			$max = $this->imap_total - $start;

			//if max is less than 1
			if ($max < 1) {
				//set max to total (ex. 300)
				$max = $this->imap_total;
			}

			//calculate min (ex. 296 - 15 + 1 = 282)
			$min = $max - $range + 1;

			//if min less than 1
			if ($min < 1) {
				//set it to 1
				$min = 1;
			}

			//now add min and max to set (ex. 282:296 or 1 - 300)
			$set = $min . ':' . $max;

			//if min equal max
			if ($min == $max) {
				//we should only get one number
				$set = $min;
			}
		}

		$items = array('UID', 'FLAGS', 'BODY[HEADER]');

		if ($body) {
			$items  = array('UID', 'FLAGS', 'BODY[]');
		}

		//now lets call this
		$emails = $this->imap_getEmailResponse('FETCH', array($set, $this->imap_getList($items)));

		//this will be in ascending order
		//we actually want to reverse this
		$emails = array_reverse($emails);

		return $emails;
	}


	public function imap_getEmailTotal(){
		return $this->imap_total;
	}


	public function imap_getNextUid(){
		return $this->imap_next;
	}

	public function imap_getMailboxes(){
		if (!$this->imap_socket) {
			$this->imap_connect();
		}

		$response = $this->imap_call('LIST', $this->imap_escape('', '*'));

		$mailboxes = array();
		foreach ($response as $line) {
			if (strpos($line, 'Noselect') !== false || strpos($line, 'LIST') == false) {
				continue;
			}

			$line = explode('"', $line);

			if (strpos(trim($line[0]), '*') !== 0) {
				continue;
			}

			$mailboxes[] = $line[count($line)-2];
		}

		return $mailboxes;
	}

	public function imap_getUniqueEmails($uid, $body = false){
		if (!$this->imap_socket) {
			$this->imap_connect();
		}
		if ($this->imap_total == 0) {
			return array();
		}

		//if uid is an array
		if (is_array($uid)) {
			$uid = implode(',', $uid);
		}

		//lets call it
		$items = array('UID', 'FLAGS', 'BODY[HEADER]');

		if ($body) {
			$items = array('UID', 'FLAGS', 'BODY[]');
		}

		$first = is_numeric($uid) ? true : false;

		return $this->imap_getEmailResponse('UID FETCH', array($uid, $this->imap_getList($items)), $first);
	}

	public function imap_getActiveInbox(){
		return $this->imap_mailbox;
	}

	public function imap_move($uid, $mailbox){
		if (!$this->imap_socket) {
			$this->imap_connect();
		}

		$this->imap_call('UID COPY '.$uid.' '.$mailbox);

		return $this->imap_remove($uid);
	}

	public function imap_remove($uid){
		if (!$this->imap_socket) {
			$this->imap_connect();
		}

		$this->imap_call('UID STORE '.$uid.' FLAGS.SILENT \Deleted');
		
	}

	public function imap_expunge(){        
		$this->imap_call('expunge');
		
	}

	public function imap_search(array $filter, $start = 0, $range = 10, $or = false, $body = false) {
		if (!$this->imap_socket) {
			$this->imap_connect();
		}

		//build a search criteria
		$search = $not = array();
		foreach ($filter as $where) {
			if (is_string($where)) {
				$search[] = $where;
				continue;
			}

			if ($where[0] == 'NOT') {
				$not = $where[1];
				continue;
			}

			$item = $where[0].' "'.$where[1].'"';
			if (isset($where[2])) {
				$item .= ' "'.$where[2].'"';
			}

			$search[] = $item;
		}

		//if this is an or search
		if ($or && count($search) > 1) {
			$query = null;
			while ($item = array_pop($search)) {
				if (is_null($query)) {
					$query = $item;
				} else if (strpos($query, 'OR') !== 0) {
					$query = 'OR ('.$query.') ('.$item.')';
				} else {
					$query = 'OR ('.$item.') ('.$query.')';
				}
			}

			$search = $query;
		} else {
			//this is an and search
			$search = implode(' ', $search);
		}

		//do the search
		$response = $this->imap_call('UID SEARCH '.$search);

		//get the result
		$result = array_pop($response);
		//if we got some results
		if (strpos($result, 'OK') !== false) {
			//parse out the uids
			$uids = explode(' ', $response[0]);
			array_shift($uids);
			array_shift($uids);

			foreach ($uids as $i => $uid) {
				if (in_array($uid, $not)) {
					unset($uids[$i]);
				}
			}

			if (empty($uids)) {
				return array();
			}

			$uids = array_reverse($uids);

			//pagination
			$count = 0;
			foreach ($uids as $i => $id) {
				if ($i < $start) {
					unset($uids[$i]);
					continue;
				}

				$count ++;

				if ($range != 0 && $count > $range) {
					unset($uids[$i]);
					continue;
				}
			}

			//return the email details for this
			return $this->imap_getUniqueEmails($uids, $body);
		}

		//it's not okay just return an empty set
		return array();
	}

	public function imap_searchTotal(array $filter, $or = false){
		if (!$this->imap_socket) {
			$this->imap_connect();
		}

		//build a search criteria
		$search = array();
		foreach ($filter as $where) {
			$item = $where[0].' "'.$where[1].'"';
			if (isset($where[2])) {
				$item .= ' "'.$where[2].'"';
			}

			$search[] = $item;
		}

		//if this is an or search
		if ($or) {
			$search = 'OR ('.implode(') (', $search).')';
		} else {
			//this is an and search
			$search = implode(' ', $search);
		}

		$response = $this->imap_call('UID SEARCH '.$search);

		//get the result
		$result = array_pop($response);

		//if we got some results
		if (strpos($result, 'OK') !== false) {
			//parse out the uids
			$uids = explode(' ', $response[0]);
			array_shift($uids);
			array_shift($uids);

			return count($uids);
		}
		//it's not okay just return 0
		return 0;
	}


	public function imap_setActiveMailbox($mailbox){

		if (!$this->imap_socket) {
			$this->imap_connect();
		}

		$response = $this->imap_call('SELECT', $this->imap_escape($mailbox));
		
		$result = $response;
		$result = array_pop($result);

		$newtotalassigned = false;
		$newnextassigned = false;
		foreach ($response as $line) {
			if (strpos($line, 'EXISTS') !== false) {
				list($star, $this->imap_total, $type) = explode(' ', $line, 3);
				$newtotalassigned = true;
			} else if (strpos($line, 'UIDNEXT') !== false) {
				list($star, $ok, $next, $this->imap_next, $type) = explode(' ', $line, 5);
				$this->next = substr($this->imap_next, 0, -1);
				$newnextassigned = true;
			}

			if ($newtotalassigned && $newnextassigned) {
				break;
			}
		}

		if (strpos($result, 'OK') !== false) {
			$this->imap_mailbox = $mailbox;
			
		}

		return true;
	}

	protected function imap_call($command, $parameters = array()){
		if (!$this->imap_send($command, $parameters)) {
			return false;
		}
		return $this->imap_receive($this->imap_tag);
	}

	/**
	 * Returns the response one line at a time
	 *
	 * @return string
	 */
	protected function imap_getLine(){
		$line = fgets($this->imap_socket);

		if ($line === false) {
			$this->imap_disconnect();
		}

		$this->imap_debug('Receiving: '.$line);

		return $line;
	}

	protected function imap_receive($sentTag){
		$this->imap_buffer = array();

		$start = time();

		while (time() < ($start + $this->imap_timeout)) {
			list($receivedTag, $line) = explode(' ', $this->imap_getLine(), 2);
			$this->imap_buffer[] = trim($receivedTag . ' ' . $line);
			if ($receivedTag == 'TAG'.$sentTag) {
				return $this->imap_buffer;
			}
		}

		return null;
	}


	protected function imap_send($command, $parameters = array()){
		$this->imap_tag ++;

		$line = 'TAG' . $this->imap_tag . ' ' . $command;

		if (!is_array($parameters)) {
			$parameters = array($parameters);
		}

		foreach ($parameters as $parameter) {
			if (is_array($parameter)) {
				if (fputs($this->imap_socket, $line . ' ' . $parameter[0] . "\r\n") === false) {
					return false;
				}

				if (strpos($this->imap_getLine(), '+ ') === false) {
					return false;
				}

				$line = $parameter[1];
			} else {
				$line .= ' ' . $parameter;
			}
		}

		$this->imap_debug('Sending: '.$line);

		return fputs($this->imap_socket, $line . "\r\n");
	}

	private function imap_debug($string){
		if ($this->imap_debugging) {
			$string = htmlspecialchars($string);
			echo '<pre>'.$string.'</pre>'."\n";
		}
		
	}


	private function imap_escape($string){
		if (func_num_args() < 2) {
			if (strpos($string, "\n") !== false) {
				return array('{' . strlen($string) . '}', $string);
			} else {
				return '"' . str_replace(array('\\', '"'), array('\\\\', '\\"'), $string) . '"';
			}
		}

		$result = array();
		foreach (func_get_args() as $string) {
			$result[] = $this->imap_escape($string);
		}

		return $result;
	}

	private function imap_getEmailFormat($email, $uniqueId = null, array $flags = array()){
		//if email is an array
		if (is_array($email)) {
			//make it into a string
			$email = implode("\n", $email);
		}

		//split the head and the body
		$parts = preg_split("/\n\s*\n/", $email, 2);

		$head = $parts[0];
		$body = null;
		if (isset($parts[1]) && trim($parts[1]) != ')') {
			$body = $parts[1];
		}

		$lines = explode("\n", $head);
		$head = array();
		foreach ($lines as $line) {
			if (trim($line) && preg_match("/^\s+/", $line)) {
				$head[count($head)-1] .= ' '.trim($line);
				continue;
			}

			$head[] = trim($line);
		}

		$head = implode("\n", $head);

		$recipientsTo = $recipientsCc = $recipientsBcc = $sender = array();

		//get the headers
		$headers1   = imap_rfc822_parse_headers($head);
		$headers2   = $this->imap_getHeaders($head);

		//set the from
		$sender['name'] = null;
		if (isset($headers1->from[0]->personal)) {
			$sender['name'] = $headers1->from[0]->personal;
			//if the name is iso or utf encoded
			if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($sender['name']))) {
				//decode the subject
				$sender['name'] = str_replace('_', ' ', mb_decode_mimeheader($sender['name']));
			}
		}

		$sender['email'] = $headers1->from[0]->mailbox . '@' . $headers1->from[0]->host;

		//set the to
		if (isset($headers1->to)) {
			foreach ($headers1->to as $to) {
				if (!isset($to->mailbox, $to->host)) {
					continue;
				}

				$recipient = array('name'=>null);
				if (isset($to->personal)) {
					$recipient['name'] = $to->personal;
					//if the name is iso or utf encoded
					if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}

				$recipient['email'] = $to->mailbox . '@' . $to->host;

				$recipientsTo[] = $recipient;
			}
		}

		//set the cc
		if (isset($headers1->cc)) {
			foreach ($headers1->cc as $cc) {
				$recipient = array('name'=>null);
				if (isset($cc->personal)) {
					$recipient['name'] = $cc->personal;

					//if the name is iso or utf encoded
					if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}

				$recipient['email'] = $cc->mailbox . '@' . $cc->host;

				$recipientsCc[] = $recipient;
			}
		}

		//set the bcc
		if (isset($headers1->bcc)) {
			foreach ($headers1->bcc as $bcc) {
				$recipient = array('name'=>null);
				if (isset($bcc->personal)) {
					$recipient['name'] = $bcc->personal;
					//if the name is iso or utf encoded
					if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}

				$recipient['email'] = $bcc->mailbox . '@' . $bcc->host;

				$recipientsBcc[] = $recipient;
			}
		}

		//if subject is not set
		if (!isset($headers1->subject) || strlen(trim($headers1->subject)) === 0) {
			//set subject
			$headers1->subject = $this->imap_no_subject;
		}

		//trim the subject
		$headers1->subject = str_replace(array('<', '>'), '', trim($headers1->subject));

		//if the subject is iso or utf encoded
		if (preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($headers1->subject))) {
			//decode the subject
			$headers1->subject = str_replace('_', ' ', mb_decode_mimeheader($headers1->subject));
		}

		//set thread details
		$topic  = isset($headers2['thread-topic']) ? $headers2['thread-topic'] : $headers1->subject;
		$parent = isset($headers2['in-reply-to']) ? str_replace('"', '', $headers2['in-reply-to']) : null;

		//set date
		$date = isset($headers1->date) ? strtotime($headers1->date) : null;

		//set message id
		if (isset($headers2['message-id'])) {
			$messageId = str_replace('"', '', $headers2['message-id']);
		} else {
			$messageId = '<mail-no-id-'.md5(uniqid()).'>';
		}

		$attachment = isset($headers2['content-type']) && strpos($headers2['content-type'], 'multipart/mixed') === 0;

		$format = array(
			'id'            => $messageId,
			'parent'        => $parent,
			'topic'         => $topic,
			'mailbox'       => $this->imap_mailbox,
			'uid'           => $uniqueId,
			'date'          => $date,
			'subject'       => str_replace('’', '\'', $headers1->subject),
			'from'          => $sender,
			'flags'         => $flags,
			'to'            => $recipientsTo,
			'cc'            => $recipientsCc,
			'bcc'           => $recipientsBcc,
			'attachment'    => $attachment);

		if (trim($body) && $body != ')') {
			//get the body parts
			$parts = $this->imap_getParts($email);

			//if there are no parts
			if (empty($parts)) {
				//just make the body as a single part
				$parts = array('text/plain' => $body);
			}

			//set body to the body parts
			$body = $parts;

			//look for attachments
			$attachment = array();
			//if there is an attachment in the body
			if (isset($body['attachment'])) {
				//take it out
				$attachment = $body['attachment'];
				unset($body['attachment']);
			}

			$format['body']         = $body;
			$format['attachment']   = $attachment;
		}

		return $format;
	}


	private function imap_getEmailResponse($command, $parameters = array(), $first = false){
		//send out the command
		if (!$this->imap_send($command, $parameters)) {
			return false;
		}

		$messageId  = $uniqueId = $count = 0;
		$emails     = $email = array();
		$start      = time();

		//while there is no hang
		while (time() < ($start + $this->imap_timeout)) {
			//get a response line
			$line = str_replace("\n", '', $this->imap_getLine());

			//if the line starts with a fetch
			//it means it's the end of getting an email
			if (strpos($line, 'FETCH') !== false && strpos($line, 'TAG'.$this->imap_tag) === false) {
				//if there is email data
				if (!empty($email)) {
					//create the email format and add it to emails
					$emails[$uniqueId] = $this->imap_getEmailFormat($email, $uniqueId, $flags);

					//if all we want is the first one
					if ($first) {
						//just return this
						return $emails[$uniqueId];
					}

					//make email data empty again
					$email = array();
				}

				//if just okay
				if (strpos($line, 'OK') !== false) {
					//then skip the rest
					continue;
				}

				//if it's not just ok
				//it will contain the message id and the unique id and flags
				$flags = array();
				if (strpos($line, '\Answered') !== false) {
					$flags[] = 'answered';
				}

				if (strpos($line, '\Flagged') !== false) {
					$flags[] = 'flagged';
				}

				if (strpos($line, '\Deleted') !== false) {
					$flags[] = 'deleted';
				}

				if (strpos($line, '\Seen') !== false) {
					$flags[] = 'seen';
				}

				if (strpos($line, '\Draft') !== false) {
					$flags[] = 'draft';
				}

				$findUid = explode(' ', $line);
				foreach ($findUid as $i => $uid) {
					if (is_numeric($uid)) {
						$uniqueId = $uid;
					}
					if (strpos(strtolower($uid), 'uid') !== false) {
						$uniqueId = $findUid[$i+1];
						break;
					}
				}

				//skip the rest
				continue;
			}

			//if there is a tag it means we are at the end
			if (strpos($line, 'TAG'.$this->imap_tag) !== false) {
				//if email details are not empty and the last line is just a )
				if (!empty($email) && strpos(trim($email[count($email) -1]), ')') === 0) {
					//take it out because that is not part of the details
					array_pop($email);
				}

				//if there is email data
				if (!empty($email)) {
					//create the email format and add it to emails
					$emails[$uniqueId] = $this->imap_getEmailFormat($email, $uniqueId, $flags);

					//if all we want is the first one
					if ($first) {
						//just return this
						return $emails[$uniqueId];
					}
				}

				//break out of this loop
				break;
			}

			//so at this point we are getting raw data
			//capture this data in email details
			$email[] = $line;
		}

		return $emails;
	}

	private function imap_getHeaders($rawData){
		if (is_string($rawData)) {
			$rawData = explode("\n", $rawData);
		}

		$key = null;
		$headers = array();
		foreach ($rawData as $line) {
			$line = trim($line);
			if (preg_match("/^([a-zA-Z0-9-]+):/i", $line, $matches)) {
				$key = strtolower($matches[1]);
				if (isset($headers[$key])) {
					if (!is_array($headers[$key])) {
						$headers[$key] = array($headers[$key]);
					}

					$headers[$key][] = trim(str_replace($matches[0], '', $line));
					continue;
				}

				$headers[$key] = trim(str_replace($matches[0], '', $line));
				continue;
			}

			if (!is_null($key) && isset($headers[$key])) {
				if (is_array($headers[$key])) {
					$headers[$key][count($headers[$key])-1] .= ' '.$line;
					continue;
				}

				$headers[$key] .= ' '.$line;
			}
		}

		return $headers;
	}


	private function imap_getList($array){
		$list = array();
		foreach ($array as $key => $value) {
			$list[] = !is_array($value) ? $value : $this->imap_getList($v);
		}

		return '(' . implode(' ', $list) . ')';
	}


	private function imap_getParts($content, array $parts = array()){
		//separate the head and the body
		list($head, $body) = preg_split("/\n\s*\n/", $content, 2);
		//front()->output($head);
		//get the headers
		$head = $this->imap_getHeaders($head);
		//if content type is not set
		if (!isset($head['content-type'])) {
			return $parts;
		}

		//split the content type
		if (is_array($head['content-type'])) {
			$type = array($head['content-type'][1]);
			if (strpos($type[0], ';') !== false) {
				$type = explode(';', $type[0], 2);
			}
		} else {
			$type = explode(';', $head['content-type'], 2);
		}

		//see if there are any extra stuff
		$extra = array();
		if (count($type) == 2) {
			$extra = explode('; ', str_replace(array('"', "'"), '', trim($type[1])));
		}

		//the content type is the first part of this
		$type = trim($type[0]);


		//foreach extra
		foreach ($extra as $i => $attr) {
			//transform the extra array to a key value pair
			$attr = explode('=', $attr, 2);
			if (count($attr) > 1) {
				list($key, $value) = $attr;
				$extra[$key] = $value;
			}
			unset($extra[$i]);
		}

		//if a boundary is set
		if (isset($extra['boundary'])) {
			//split the body into sections
			$sections = explode('--'.str_replace(array('"', "'"), '', $extra['boundary']), $body);
			//we only want what's in the middle of these sections
			array_pop($sections);
			array_shift($sections);

			//foreach section
			foreach ($sections as $section) {
				//get the parts of that
				$parts = $this->imap_getParts($section, $parts);
			}
		} else {
			//if name is set, it's an attachment
			//if encoding is set
			if (isset($head['content-transfer-encoding'])) {
				//the goal here is to make everytihg utf-8 standard
				if (is_array($head['content-transfer-encoding'])) {
					$head['content-transfer-encoding'] = array_pop($head['content-transfer-encoding']);
				}

				switch (strtolower($head['content-transfer-encoding'])) {
					case 'binary':
						$body = imap_binary($body);
						break;
					case 'base64':
						$body = base64_decode($body);
						break;
					case 'quoted-printable':
						$body = quoted_printable_decode($body);
						break;
					case '7bit':
						$body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
						break;
					default:
						break;
				}
			}

			if (isset($extra['name'])) {
				//add to parts
				$parts['attachment'][$extra['name']][$type] = $body;
			} else {
				//it's just a regular body
				//add to parts
				$parts[$type] = $body;
			}
		}
		return $parts;
	}
}

// if IMAP PHP is not installed we still need these functions
if (!function_exists('imap_rfc822_parse_headers')) {
	function imap_rfc822_parse_headers_decode($from){
		if (preg_match('#\<([^\>]*)#', html_entity_decode($from))) {
			preg_match('#([^<]*)\<([^\>]*)\>#', html_entity_decode($from), $From);
			$from = array(
				'personal'  => trim($From[1]),
				'email'     => trim($From[2]));
		} else {
			$from = array(
				'personal'  => '',
				'email'     => trim($from));
		}

		preg_match('#([^\@]*)@(.*)#', $from['email'], $from);

		if (empty($from[1])) {
			$from[1] = '';
		}

		if (empty($from[2])) {
			$from[2] = '';
		}

		$__from = array(
			'mailbox'   => trim($from[1]),
			'host'      => trim($from[2]));

		return (object) array_merge($from, $__from);
	}

	function imap_rfc822_parse_headers($header){
		$header = htmlentities($header);
		$headers = new \stdClass();
		$tos = $ccs = $bccs = array();
		$headers->to = $headers->cc = $headers->bcc = array();

		preg_match('#Message\-(ID|id|Id)\:([^\n]*)#', $header, $ID);
		$headers->ID = trim($ID[2]);
		unset($ID);

		preg_match('#\nTo\:([^\n]*)#', $header, $to);
		if (isset($to[1])) {
			$tos = array(trim($to[1]));
			if (strpos($to[1], ',') !== false) {
				explode(',', trim($to[1]));
			}
		}

		$headers->from = array(new \stdClass());
		preg_match('#\nFrom\:([^\n]*)#', $header, $from);
		$headers->from[0] = imap_rfc822_parse_headers_decode(trim($from[1]));

		preg_match('#\nCc\:([^\n]*)#', $header, $cc);
		if (isset($cc[1])) {
			$ccs = array(trim($cc[1]));
			if (strpos($cc[1], ',') !== false) {
				explode(',', trim($cc[1]));
			}
		}

		preg_match('#\nBcc\:([^\n]*)#', $header, $bcc);
		if (isset($bcc[1])) {
			$bccs = array(trim($bcc[1]));
			if (strpos($bcc[1], ',') !== false) {
				explode(',', trim($bcc[1]));
			}
		}

		preg_match('#\nSubject\:([^\n]*)#', $header, $subject);
		$headers->subject = trim($subject[1]);
		unset($subject);

		preg_match('#\nDate\:([^\n]*)#', $header, $date);
		$date = substr(trim($date[0]), 6);

		$date = preg_replace('/\(.*\)/', '', $date);

		$headers->date = trim($date);
		unset($date);

		foreach ($ccs as $k => $cc) {
			$headers->cc[$k] = imap_rfc822_parse_headers_decode(trim($cc));
		}

		foreach ($bccs as $k => $bcc) {
			$headers->bcc[$k] = imap_rfc822_parse_headers_decode(trim($bcc));
		}

		foreach ($tos as $k => $to) {
			$headers->to[$k] = imap_rfc822_parse_headers_decode(trim($to));
		}

		return $headers;
	}
 }
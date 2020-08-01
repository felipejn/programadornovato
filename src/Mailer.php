<?php  

namespace Pronov;

use Rain\Tpl;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{

	const USERNAME = "";
	const PASSWORD = ""; 
	const NAME_FROM = "Programador Novato";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
					"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
					"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
					"debug"			=> false
		);

		Tpl::configure( $config );	

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			
			$tpl->assign($key, $value);

		}

		$html = $tpl->draw($tplName, true);

		//Create a new PHPMailer instance
		$mail = new PHPMailer();

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// SMTP::DEBUG_OFF = off (for production use)
		// SMTP::DEBUG_CLIENT = client messages
		// SMTP::DEBUG_SERVER = client and server messages
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;

		//Set the hostname of the mail server
		$mail->Host = 'smtp-pt.securemail.pro';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 465;

		//Set the encryption mechanism to use - STARTTLS or SMTPS
		$mail->SMTPSecure = 'ssl'; // PHPMailer::ENCRYPTION_STARTTLS;

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = Mailer::USERNAME;

		//Password to use for SMTP authentication
		$mail->Password = Mailer::PASSWORD;

		//Set who the message is to be sent from
		$mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

		// //Set an alternative reply-to address
		// $mail->addReplyTo('replyto@example.com', 'First Last');

		//Set who the message is to be sent to
		$mail->addAddress($toAddress, $toName);

		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($html);

		//Replace the plain text body with one created manually
		$mail->AltBody = 'Use a html compatible browser to read this message.';

		// //Attach an image file
		// $mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			echo 'Mailer Error: '. $mail->ErrorInfo;
		} else {
			echo 'Message sent!';
			//Section 2: IMAP
			//Uncomment these to save your message in the 'Sent Mail' folder.
			#if (save_mail($mail)) {
			#    echo "Message saved!";
			#}
		}

	}

}

?>
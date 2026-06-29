<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'contact@example.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;

  // Validate required fields
  $name  = isset($_POST['name'])         ? trim($_POST['name'])         : '';
  $email = isset($_POST['email'])        ? trim($_POST['email'])        : '';
  $phone = isset($_POST['Phone Number']) ? trim($_POST['Phone Number']) : '';
  $msg   = isset($_POST['message'])      ? trim($_POST['message'])      : '';

  if (empty($name) || empty($email) || empty($msg)) {
    die('Please fill in all required fields.');
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
  }

  // Strip any newlines from fields used in headers to prevent injection
  $name  = str_replace(["\r", "\n"], '', $name);
  $email = str_replace(["\r", "\n"], '', $email);
  $phone = str_replace(["\r", "\n"], '', $phone);

  $contact->to = $receiving_email_address;
  $contact->from_name = $name;
  $contact->from_email = $email;
  $contact->subject = $phone;

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  $contact->add_message( $name,  'From');
  $contact->add_message( $email, 'Email');
  $contact->add_message( $msg,   'Message', 10);

  echo $contact->send();
?>

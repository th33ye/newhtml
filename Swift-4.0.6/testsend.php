<?php
   require_once 'lib/swift_required.php';

   $transport = Swift_SmtpTransport::newInstance("smtp.gmail.com", "465", 'ssl')
      ->setUsername('abenmachtech@gmail.com')
      ->setPassword('sabong$$$');

   $mailer = Swift_Mailer::newInstance($transport);
   $message = Swift_Message::newInstance('Test Email from UK')
      ->setFrom(array('abenmachtech@gmail.com' => 'abenmach'))
      ->setTo(array('arvinsanandres@gmail.com' => 'arvin'))
      ->setBody('This is a test message. pls dont reply');
   $numSent = $mailer->send($message);
   printf("Sent %d messages\n", $numSent);

?>

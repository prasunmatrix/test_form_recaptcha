<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'PHPMailer-master/src/Exception.php';
  require 'PHPMailer-master/src/PHPMailer.php';
  require 'PHPMailer-master/src/SMTP.php';

  $user_name=$_POST['user_name'];
  $user_email=$_POST['user_email'];
  $user_contact=$_POST['user_contact'];
  $user_company_name=$_POST['user_company_name'];
  $user_message=$_POST['user_message']; 

  $sendMails=array('prasun@matrixnmedia.com');

  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPDebug  = 0;
  $mail->SMTPAuth   = TRUE;

  $mail->SMTPSecure = "tls";
  $mail->Port       = 587;
  $mail->Host       = "smtp.gmail.com";
  $mail->Username   = "matrixweb2021@gmail.com";
  $mail->Password   = "lgkvifnzhtlbfzwi";

  $mail->IsHTML(true);
  foreach($sendMails as $sendMail)
  {
    $mail->AddAddress($sendMail);
  }
  $mail->SetFrom("test@gmail.com", "Practice");
  $mail->AddReplyTo("test@gmail.com", "Practice");
  //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
  $mail->Subject = $user_name . " connecting through Practice contact form";
  // $content = "Thank you for contacting us.";
  // $content.="<br>";
  // $content .="We will back to you shortly";
  // $content.="<br><br>";
  // $content.="<p>Thanks & regards,</p>";
  // $content.="<p>Rydair</p>";
  $content = 'The following details as follows:';
  $content .= '<br>';
  $content .= '<p><strong>Name: </strong>' . $user_name . '</p>';
  $content .= '<p><strong>Email: </strong>' . $user_email . '</p>';
  $content .= '<p><strong>Mobile Number: </strong>' . $user_contact . '</p>';
  $content .= '<p><strong>Company: </strong>' . $user_company_name . '</p>';
  $content .= '<p><strong>Message: </strong>' . $user_message . '</p>';
  $content .= "<p>Thanks & regards,</p>";
  $content .= "<p>Practice</p>";
  $mail->MsgHTML($content);

  if (!$mail->send()) {
    $data['success'] = false;
    $data['errors'] = 'Message could not be sent';
} else {
    $data['success'] = true;
    $data['message'] = 'Your enquiry has been sent.';
}

echo json_encode($data);

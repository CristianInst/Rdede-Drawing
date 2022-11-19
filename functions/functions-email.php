<?php

function contact_email(){

	if (!check_ajax_referer( 'ajax-nonce', 'security', false )) {
		respond_and_close(false, 'Security Incorrect');
	}

	check_required($_POST);

	//Email administrator
    $to = 'dev@authenticity.digital';
	$title   = get_bloginfo('name') . ' Contact Form Enquiry';
	$message = build_message($title, $_POST);
	$body    = build_header($title) . $message . build_footer();

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'From: noreply@itc-uk.com <noreply@itc-uk.com>';
    $headers[] = 'Bcc: dev@authenticity.digital';

	// Send the email
	$email = wp_mail($to, $title, $body, $headers);

	// Depending on the email submission, echo the success or failure json data
	if ( $email ){
		respond_and_close(true, array( 'heading' => 'Thank you', 'content' => 'Your details have been sent, a member of our team will be in touch to discuss your enquiry.' ));
	} else {
		respond_and_close(false, array( 'heading' => 'Error', 'content' => 'Unfortunately an error occured when trying to send your enquiry. Please try again later.' ));
	}
}
add_action('wp_ajax_contact_email', 		'contact_email'); // for logged in user
add_action('wp_ajax_nopriv_contact_email', 	'contact_email'); // if user not logged in


function autorespond($to, $from){

    //Email User
    $title   = 'Thank you for contacting us';
  
    $message = '<h1>' . $title . '</h1><p>A member of our team will process your message shortly.</p>';
  
    $body    = build_header($title) . $message . build_footer();
  
    $headers  = "From: ITC UK<". $from . ">\r\n";
    $headers .= "Reply-To: ". $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
  
    //Send the email
    $email = wp_mail($to, $title, $body, $headers);
  
  }
  
  // Used to check ajax sent forms for required fields
  function check_required($data) {
      $errs = array();
  
      $reqs = json_decode(stripslashes($data['required']), true);
  
      $reqs = array_unique($reqs, SORT_REGULAR);
  
      foreach ($reqs as $key => $req) {
          $type = $req['type'];
          $name = str_replace('"', "'", $req['name']);
  
          switch ($type) {
            case 'email':
                if (!filter_var($entry, FILTER_VALIDATE_EMAIL)) {
                    array_push($errs, $name);
                }
                break;
            case 'tel':
                $entry = str_replace("[^0-9]", "", $entry);

                if (strlen($entry) < 7 || strlen($entry) > 14) {
                    array_push($errs, $name);
                }
                break;
            default:
                if (empty($entry)) {
                    array_push($errs, $name);
                }
                break;
        }
  
      }
  
      if (!empty($errs)) {
          respond_and_close(false, $errs);
      }
  }
    
    // Builds HTML emails
    function build_message($title, $data) {
        $message = '<h1>' . $title . '</h1>';
    
        foreach ($data as $key => $value) {
            if ($key !== 'security' && $key !== 'action' && $key !== 'to' && $key !== 'required') {

                $expVal = explode('--', $value);
                $outputVal = count($expVal) > 1 ? $expVal[1] : $value;
                $message .= '<p><strong>' . str_replace( '-', ' ', ucfirst($key) ) . ':</strong> ' . str_replace('-', ' ', $outputVal) .'</p>';

            }
        }
    
        return $message;
    }
  
  function build_header($title){
      $email_header = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
          <html xmlns:v="urn:schemas-microsoft-com:vml">
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>' . $title . '</title>
          </head>
  
          <body marginheight="0" bgcolor="#f2f2f2" style="margin:0px; padding:0px;">
          <table table style="width: 600px; margin: auto;" border="0" cellpadding="20" cellspacing="0" align="center" bgcolor="#FFFFFF">
              <tr>
                  <td width="600">';
  
      return $email_header;
  }
  
  function build_footer(){
      $email_footer = '</td>
      </tr>
      </table>
      </body>
      </html>';
  
      return $email_footer;
  }
  

// Ajax response helper
function respond_and_close($status, $response = null){

	//Setup the returns we will use
	$data = array();

	$data['success'] = $status;
	$data['data'] = $response;

	echo json_encode($data);
	exit;
}
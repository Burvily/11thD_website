<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = strip_tags(trim($_POST["fullname"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $message = trim($_POST["message"]);

    // Validate required fields
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill in all required fields with valid information.";
        exit;
    }

    // Set recipient email address
    $recipient = "info@theeleventhdimension.co.uk"; // Replace with your desired email address

    // Set email subject
    $subject = "New Contact from Eleventh Dimension Website (UK) by: $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Redirect to a success page or display a success message
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Display an error message
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Not a POST request, display an error
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
<!doctype html>
<html>
<head>
    <title>Form test</title>
    <meta charset="utf-8" />
    <meta name= "viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php

    // Array of all the input field names
    $form_val = array("f_name", "l_name", "email", "tel", "addr1", "addr2",
        "town", "county", "postcode", "country", "descript");

    // Variable allowing form submission
    $can_submit = true;

    // loops through form values and sets to input values or null if empty
    // determines if form can be submitted if required fields are empty
    foreach($form_val as $inputs){
        if(empty($_POST[$inputs])){
            ${$inputs} = null;
            if(!($inputs == "addr2" || $inputs == "descript")){
                $can_submit = false;
            }        
        } 
        else{
            ${$inputs} = $_POST[$inputs];
        }
    }

    // echo $tel."<br/>";
    // echo strlen($tel)."<br/>";

    // Checks valid email
    $email_warning = '';

    if($email!=null){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_warning  = "Invalid email address";
            $can_submit = false;
          }
    }

    // Checks validitiy of phone number
    $tel_warning = '';

    if($tel!=null){
        if(!is_numeric($tel)){
            $tel_warning = "Must only contain numbers!";
            $can_submit = false; 
        }
        else if(strlen($tel)<9 || strlen($tel)>11){
            $tel_warning = "Must be 9 to 11 digits!";
            $can_submit = false;
        }
    }

    // if($can_submit){
    //     echo "true";
    // }else{
    //     echo "false";
    // }

    // creates error message to be added to UI if required fields are empty
    function errorMsg($arg){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST[$arg])) {
            $message = "Please Enter a Value!";
            return $message;
            } else {
            return;
            }
        }
    }
    
    // Creates email body text
    $body = "First Name: ".$f_name."\n";
    $body .= "Last Name: ".$l_name."\n";
    $body .= "Email: ".$email."\n";
    $body .= "Telephone: ".$tel."\n";
    $body .= "Address 1: ".$addr1."\n";
    if($addr2 != null ){
        $body .= "Address 2: ".$addr2."\n";
    }
    $body .= "Town: ".$town."\n";
    $body .= "County: ".$county."\n";
    $body .= "Postcode: ".$postcode."\n";
    $body .= "Country: ".$country."\n";
    if($descript != null){
        $body .= "Description: ".$descript."\n";
    }
    // echo $body;

    // email parameters
    ini_set("SMTP", $email);
    ini_set("sendmail_from", $email);

    $to = $email;
    $subject = "Form Submission";
    $message = $body;
    $headers = "From: ".$email;

    // sends email
    if ($can_submit){
        mail($to, $subject, $message, $headers);
    }
?>
    <form method="post" name="myemailform" action="index.php">
        <div class = "form-table">
            <div class = "form-cell">
                <label for="f_name">First name</label><br/>
                <input id ="f_name" class="field_bx" type="text" name="f_name" 
                    value="<?php echo $f_name ?>"
                />
                <span class = "error"><?php echo errorMsg('f_name'); ?></span>
            </div>
            <div class = "form-cell">
                <label for="l_name">Last name</label><br/>
                <input id ="l_name" class="field_bx" type="text" name="l_name"
                    value="<?php echo $l_name ?>"
                />
                <span class = "error"><?php echo errorMsg('l_name'); ?></span>
            </div>
            <div class = "form-cell">
                <label for="email">Email</label><br/>
                <input id ="email" class="field_bx" type="email" name="email"
                    value="<?php echo $email ?>"
                />
                <span class = "error"><?php echo errorMsg('email');  echo $email_warning;?></span>
            </div>
            <div class = "form-cell">
                <label for="tel">Telephone</label><br/>
                <input id ="tel" class="field_bx" type="text" name="tel"
                    value="<?php echo $tel ?>"
                />
                <span class = "error"><?php echo errorMsg('tel'); echo $tel_warning; ?></span>
            </div>
            <div class = "form-cell">
                <label for="addr_1">Address 1</label><br/>
                <input id ="addr_1" class="field_bx" type="text" name="addr1"
                    value="<?php echo $addr1 ?>"
                />
                <span class = "error"><?php echo errorMsg('addr1'); ?></span>
            </div>
            <div class = "form-cell">
                <label for="addr_2">Address 2</label><br/>
                <input id ="addr_2" class="field_bx" type="text" name="addr2"
                    value="<?php echo $addr2 ?>"
                />
            </div>
            <div class = "form-cell">
                <label for="town">Town</label><br/>
                <input id ="town" class="field_bx" type="text" name="town"
                    value="<?php echo $town ?>"
                />
                <span class = "error"><?php echo errorMsg('town'); ?></span>
            </div>
            <div class = "form-cell">
                <label for="county">County</label><br/>
                <input id ="county" class="field_bx" type="text" name="county"
                    value="<?php echo $county ?>"
                />
                <span class = "error"><?php echo errorMsg('county'); ?></span>
            </div>
            <div class = "form-cell">
                <label for="postcode">Postcode</label><br/>
                <input id ="postcode" class="field_bx" type="text" name="postcode"
                    value="<?php echo $postcode ?>"
                />
                <span class = "error"><?php echo errorMsg('postcode'); ?></span>
            </div>
            <div class = "form-cell">
                <label for="county">Country</label><br/>
                <select id ="country" class="field_bx" type="text" name="country">
                    <?php include_once 'countries.php' ?>
                <select>
                <span class = "error"><?php echo errorMsg('country'); ?></span>
            </div>
            <div class = "form-cell description">
                <label for="descript">Description</label><br/>
                <textarea id ="descript" class="field_bx" name="descript"><?php echo $descript ?></textarea>
            </div>
            <div>
                <p>Your C.V</p>
                <span>Select a file <span><input type="file" name="upload" id="upload">
            </div>
            <input class = "submit" type="submit" value ="Submit">
        </div>
    </form>
</body>
</html>
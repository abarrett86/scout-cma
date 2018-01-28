<?php

global $wpdb;

function handlePost(){

    if(!isset($_POST["api_key"])){
        return;
    }

    $newApiKey = $_POST["api_key"];
    $newSubmitText = $_POST["submit_text"];
    $newSuccessMessage = $_POST["suCcess_message"];
    $newFailMessage = $_POST["fail_message"];
    $badAddressMessage = $_POST["bad_address_message"];
    
    update_option(CMA_API_OPTION, $newApiKey);
    update_option(CMA_API_SUBMIT_TEXT, $newSubmitText);
    update_option(CMA_SUCCESS_MESSAGE_OPTION, $newSuccessMessage);
    update_option(CMA_FAIL_MESSAGE_OPTION, $newFailMessage);
    update_option(CMA_BAD_ADDRESS_MESSAGE_OPTION, $badAddressMessage);

}

handlePost();

$api_key = get_option(CMA_API_OPTION);
$submit_text = get_option(CMA_API_SUBMIT_TEXT);
$success_message = get_option(CMA_SUCCESS_MESSAGE_OPTION);
$fail_message = get_option(CMA_FAIL_MESSAGE_OPTION);
$bad_address_message = get_option(CMA_BAD_ADDRESS_MESSAGE_OPTION);

?>


<h1>CMA Widget Options</h1>


<form  method="post" enctype="multipart/form-data">
    <label>API Key</label><br/><input type="text" name="api_key" style="width: 450px;" value="<?php print $api_key; ?>"></input><br/><br/>
    <label>Submit Button Text</label><br/><input type="text" name="submit_text" style="width: 450px;" value="<?php print $submit_text; ?>"></input><br/><br/>
    <label>Success Message</label><br/><input type="text" name="suCcess_message" style="width: 450px;" value="<?php print $success_message; ?>"></input><br/><br/>
    <label>General Fail Message</label><br/><input type="text" name="fail_message" style="width: 450px;" value="<?php print $fail_message; ?>"></input><br/><br/>
    <label>Bad Address Message</label><br/><input type="text" name="bad_address_message" style="width: 450px;" value="<?php print $bad_address_message; ?>"></input>
    <?php submit_button('Save') ?>
</form>





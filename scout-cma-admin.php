<?php

global $wpdb;

function handlePost(){

    if(!isset($_POST["api_key"])){
        return;
    }

    $newApiKey = $_POST["api_key"];
    $newSuccessMessage = $_POST["suCcess_message"];
    $newFailMessage = $_POST["fail_message"];
    
    update_option(CMA_API_OPTION, $newApiKey);
    update_option(CMA_SUCCESS_MESSAGE_OPTION, $newSuccessMessage);
    update_option(CMA_FAIL_MESSAGE_OPTION, $newFailMessage);

}

handlePost();

$api_key = get_option(CMA_API_OPTION);
$success_message = get_option(CMA_SUCCESS_MESSAGE_OPTION);
$fail_message = get_option(CMA_FAIL_MESSAGE_OPTION);

?>


<h1>CMA Widget Options</h1>


<form  method="post" enctype="multipart/form-data">
    <label>API Key</label><br/><input type="text" name="api_key" value="<?php print $api_key; ?>"></input><br/><br/>
    <label>Success Message</label><br/><input type="text" name="suCcess_message" value="<?php print $success_message; ?>"></input><br/><br/>
    <label>Fail Message</label><br/><input type="text" name="fail_message" value="<?php print $fail_message; ?>"></input>
    <?php submit_button('Save') ?>
</form>





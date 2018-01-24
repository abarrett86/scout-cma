function ScoutCMAWidget ($root){
    this.$root = $root;

    this.invalidInputClass = "input_invalid";

    var self = this;

    //add listeners
    jQuery(this.$root).find('input').change(function(){
        self.updateValues()
    });

    jQuery(this.$root).find('input').keyup(function(){
        self.updateValues()
    });

    this.nameInput = jQuery(this.$root).find('.cma_input_name');
    this.emailInput = jQuery(this.$root).find('.cma_input_email');
    this.streetInput = jQuery(this.$root).find('.cma_input_street');
    this.cityInput = jQuery(this.$root).find('.cma_input_city');
    this.stateInput = jQuery(this.$root).find('.cma_input_state');
    this.zipInput = jQuery(this.$root).find('.cma_input_zip');
    this.sqftInput = jQuery(this.$root).find('.cma_input_sqft');
    this.successMessage = jQuery(this.$root).find('.cma_success_message');
    this.failMessage = jQuery(this.$root).find('.cma_fail_message');
    
    this.submitButton = jQuery(this.$root).find('.cma_submit_button');

    jQuery(this.submitButton).click(function(){
        self.send();
    })

    //set success and failure message from wordpress options
    jQuery(this.successMessage).html(cma_options.cma_success_message_key);
    jQuery(this.failMessage).html(cma_options.cma_fail_message_key);

    this.updateValues();

}



ScoutCMAWidget.prototype.checkSubmitReady = function(){
    
    var valid = true;

    //name
    if(this.nameValue.length < 3){
        valid = false;
        jQuery(this.nameInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.nameInput).parent().removeClass(this.invalidInputClass);
    }

    //email
    if(!this.checkValidEmail()){
        valid = false;
        jQuery(this.emailInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.emailInput).parent().removeClass(this.invalidInputClass);
    }

    //street
    if(this.streetValue.length < 3){
        valid = false;
        jQuery(this.streetInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.streetInput).parent().removeClass(this.invalidInputClass);
    }

    //city
    if(this.cityValue.length < 2){
        valid = false;
        jQuery(this.cityInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.cityInput).parent().removeClass(this.invalidInputClass);
    }

    //state
    if(this.stateValue.length != 2){
        valid = false;
        jQuery(this.stateInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.stateInput).parent().removeClass(this.invalidInputClass);
    }
    
    //zip
    if(!this.checkValidZip()){
        valid = false;
        jQuery(this.zipInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.zipInput).parent().removeClass(this.invalidInputClass);
    }

    //sqft
    if(!this.checkValueNumeric(this.sqftValue)){
        valid = false;
        jQuery(this.sqftInput).parent().addClass(this.invalidInputClass);
    }else{
        jQuery(this.sqftInput).parent().removeClass(this.invalidInputClass);
    }

    jQuery(this.submitButton).prop('disabled', !valid);

}

ScoutCMAWidget.prototype.updateValues = function(){
    
    this.nameValue = jQuery(this.nameInput).val();
    this.emailValue = jQuery(this.emailInput).val();
    this.streetValue = jQuery(this.streetInput).val();
    this.cityValue = jQuery(this.cityInput).val();
    this.stateValue = jQuery(this.stateInput).val();
    this.zipValue = jQuery(this.zipInput).val();
    this.sqftValue = jQuery(this.sqftInput).val();

    this.checkSubmitReady();

}

ScoutCMAWidget.prototype.checkValidEmail = function() {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(this.emailValue);
}

ScoutCMAWidget.prototype.checkValidZip = function(){
    var splitZip = this.zipValue.split('-');

    if(splitZip.length < 1 || splitZip.length > 2){
        return false;
    }

    for(var i = 0; i < splitZip.length; i++){
        if(!this.checkValueNumeric(splitZip[i])){
            return false;
        }
    }

    return true;
}

ScoutCMAWidget.prototype.checkValueNumeric = function(value){
    return !isNaN(value) && value != '';
}

ScoutCMAWidget.prototype.onSubmitSuccess = function(){
    //show thank-you message
    jQuery(this.failMessage).hide();
    jQuery(this.submitButton).hide();
    jQuery(this.successMessage).show();

}

ScoutCMAWidget.prototype.onSubmitFail = function(){
    
    //show failure message
    jQuery(this.failMessage).show();
    jQuery(this.successMessage).hide();

    //re-enable button
    jQuery(this.submitButton).prop('disabled', false);
}

ScoutCMAWidget.prototype.send = function(){
    
    jQuery(this.submitButton).prop('disabled', true);

    var url = "http://cloudcma.com/cmas/widget";

    var data = {
        api_key : cma_options.cma_api_key,
        email_to: this.emailValue,
        address: this.streetValue + " " + this.cityValue + ", " + this.stateValue + " " + this.zipValue,
        sqft: this.sqftValue,
        name: this.nameValue
    }

    jQuery.ajax({
        type: "POST",
        url: url,
        data: data,
        success: jQuery.proxy(self, self.onSubmitSuccess),
        error: jQuery.proxy(self, self.onSubmitFail),
        fail: jQuery.proxy(self, self.onSubmitFail)
        });

    //TODO: ajax call to our server to store the input form for posterity
}
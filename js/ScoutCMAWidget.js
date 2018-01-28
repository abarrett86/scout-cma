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
    this.message = jQuery(this.$root).find('.cma_message');
    
    this.submitButton = jQuery(this.$root).find('.cma_submit_button');

    jQuery(this.submitButton).html(cma_options.submit_text);

    jQuery(this.submitButton).click(function(){
        self.send();
    })

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

ScoutCMAWidget.prototype.send = function(){
    
    var self = this;

    jQuery(this.submitButton).prop('disabled', true);

    var url = "http://cloudcma.com/cmas/widget";

    var data = {
        action: 'cma_form',
        email_to: this.emailValue,
        address: this.streetValue + " " + this.cityValue + ", " + this.stateValue + " " + this.zipValue,
        sqft: this.sqftValue,
        name: this.nameValue
    }

	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(cma_options.ajax_url, data, function(response) {

        var json = JSON.parse(response);

        if(json.status == "success"){
            self.$root.removeClass("cma_failed");
            self.$root.addClass("cma_success");
        }else{
            self.$root.removeClass("cma_success");
            self.$root.addClass("cma_failed");
        }

        jQuery(self.message).html(json.message);
        jQuery(self.submitButton).prop('disabled', json.status == "success");

	});
}
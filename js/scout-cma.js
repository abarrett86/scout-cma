

jQuery(document).ready(function(){

    jQuery(".scout_cma_widget").each(function(index){
        var t = new ScoutCMAWidget(jQuery(this));           
    });
});
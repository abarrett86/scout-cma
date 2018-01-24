/*
        jQuery flying-labels plugin.
        By Vladislav Fedotov.
        Released at 22.09.2017 - v 1.0.0
*/

;(function($){
    var methods = {
        show: function(e){
            var dataFor = jQuery(e.target).attr('name');
            var $placeholder = jQuery("."+config.placeholderClass+"[data-for='"+dataFor+"']");
            var $field = jQuery("[name='"+dataFor+"']");
            if($field.val()!=""){
                if($placeholder.first().length==0){
                    jQuery("<div/>", {
                        "class": config.placeholderClass,
                        "data-for": dataFor,
                        text: $field.attr('placeholder')
                    }).insertAfter($field).css('animation', config.showAnimation+' forwards '+config.animationTime+'ms').show();
                }else $placeholder.first().css('animation', config.showAnimation+' forwards '+config.animationTime+'ms').show();
            }  
        },  
        hide: function(e){
            var dataFor = jQuery(e.target).attr('name');
            var $placeholder = jQuery("."+config.placeholderClass+"[data-for='"+dataFor+"']");
            var $field = jQuery("[name='"+dataFor+"']");
            if($field.val()==""){
                $placeholder.first().css('animation', config.hideAnimation+' forwards '+config.animationTime/2+'ms');
            }
            
        },
        init: function(obj){
            console.log(obj);
            if(obj[0].tagName==="INPUT" && obj.attr('type')!="password" && obj.attr('type')!="text") return;
            if(obj[0].tagName!=="INPUT" && obj[0].tagName!=="TEXTAREA") return;
            if(typeof obj.attr('placeholder')==="undefined") return;
            if(!obj.parent().hasClass(config.wrapperClass)) obj.wrap("<div class='"+config.wrapperClass+"'/>");
            if(obj.val().trim()!=""){
                jQuery("<div/>", {
                    "class": config.placeholderClass,
                    "data-for": obj.attr('name'),
                    text: obj.attr('placeholder')
                }).appendTo(obj.parent()).fadeIn(config.animationTime);
            }
            obj.on("keyup.fly", methods.show);
            obj.on("change.fly keyup.fly keydown.fly", methods.hide);
        },
        destroy: function(obj){
            obj.off("keyup.fly change.fly keydown.fly");
            jQuery("."+config.placeholderClass+"[data-for='"+obj.attr('name')+"']").remove();
        }
    }
    var config, defaults = {
        'wrapperClass': 'it-wrapper',
        'placeholderClass': 'placeholder',
        'animationTime': '200',
        'showAnimation': 'slideInUp',
        'hideAnimation': 'zoomOut'
    };
    console.log('add fly func');
    jQuery.fn.fly = function(options){
        console.log("fly");
        console.log(options);
        if(options!=="destroy") config = jQuery.extend(defaults, options);
        return this.each(function(){   
            if(options!=="destroy") methods.init(jQuery(this));
            else methods.destroy(jQuery(this));
        });
    }
})(jQuery);
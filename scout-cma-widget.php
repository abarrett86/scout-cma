<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="scout_cma_widget">
    <div class="scout_cma_line col-xs-12">
      <div class="scout_cma_label">Your Name <span class="scout_cma_note">*</span></span></div>
      <input class="cma_input_name" type="text" placeholder="Name" />
    </div>

    <div class="scout_cma_line col-xs-12">
      <div class="scout_cma_label">Email Address <span class="scout_cma_note">*</span></span></div>  
      <input class="cma_input_email" type="text" placeholder="example@example.com" />     
    </div>
    
    <div class="scout_cma_line col-xs-12">
      <div class="scout_cma_label">Street <span class="scout_cma_note">*</span></span></div>  
      <input class="cma_input_street" type="text" placeholder="Street" />
    </div>
    
    <div class="scout_cma_line col-xs-12">
      <div class="col-xs-12 col-sm-6 leftHalf">
        <div class="scout_cma_label">City <span class="scout_cma_note">*</span></span></div>  
        <input class="cma_input_city" type="text" placeholder="City" />     
      </div>
    
      <div class="col-xs-12 col-sm-6 rightHalf">
        <div class="scout_cma_label">State <span class="scout_cma_note">*</span></span></div>  
        <input class="cma_input_state" type="text" placeholder="State" maxLength=2 />
      </div>
    </div>

    <div class="clear"></div>

    <div class="scout_cma_line col-xs-12">
      <div class="col-xs-12 col-sm-6 leftHalf">
        <div class="scout_cma_label">Zip Code <span class="scout_cma_note">*</span></span></div>  
        <input class="cma_input_zip" type="text" placeholder="Zip" />
      </div>
    
      <div class="col-xs-12 col-sm-6 rightHalf">
        <div class="scout_cma_label">Square Foot of Home <span class="scout_cma_note">*</span></span></div>  
        <input class="cma_input_sqft" type="text" placeholder="SQFT"  />
      </div>
    </div>

    <div class="scout_cma_line col-xs-12">
      <button class="cma_submit_button">SEND ME THE VALUE OF MY HOME</button>
    </div>

    <div class="scout_cma_line col-xs-12 scout_cma_note_master">
      <span class="scout_cma_note">*Required Field</span>
    </div>

    <div class="scout_cma_line col-xs-12">
      <div class="cma_message"></div>
    </div>

    <div class="clear"></div>
</div>
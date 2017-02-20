<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment/securehosting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_shreference; ?></td>
            <td><input type="text" name="securehosting_shreference" value="<?php echo $securehosting_shreference; ?>" />
              <?php if ($error_shreference) { ?>
              <span class="error"><?php echo $error_shreference; ?></span>
              <?php } ?>
			</td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_checkcode; ?></td>
            <td><input type="text" name="securehosting_checkcode" value="<?php echo $securehosting_checkcode; ?>" />
              <?php if ($error_checkcode) { ?>
              <span class="error"><?php echo $error_checkcode; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_filename; ?></td>
            <td><input type="text" name="securehosting_filename" value="<?php echo $securehosting_filename; ?>" />
              <?php if ($error_filename) { ?>
              <span class="error"><?php echo $error_filename; ?></span>
              <?php } ?></td>
          </tr>
		  <tr>
			  <td><?php echo $entry_as ?></td>
			  <td><select name="securehosting_as" onchange="this.form.securehosting_as_phrase.disabled = this.value == '0';this.form.securehosting_as_referrer.disabled = this.value == '0';">
					  <?php if($securehosting_as){ ?>
					  <option value="1" selected="selected">Yes</option>
					  <option value="0">No</option>
					  <?php } else { ?>
					  <option value="1">Yes</option>
					  <option value="0" selected="selected">No</option>
					  <?php } ?>
				  </select></td>
		  </tr>
		  <tr>
			  <td><span class="required">*</span> <?php echo $entry_as_phrase; ?></td>
            <td><input type="text" name="securehosting_as_phrase" value="<?php echo $securehosting_as_phrase; ?>" <?php if(!$securehosting_as) echo 'disabled="disabled"' ?> />
              <?php if ($error_as_phrase) { ?>
              <span class="error"><?php echo $error_as_phrase; ?></span>
              <?php } ?></td>
		  </tr>
		  <tr>
			  <td><span class="required">*</span> <?php echo $entry_as_referrer; ?></td>
            <td><input type="text" name="securehosting_as_referrer" value="<?php echo $securehosting_as_referrer; ?>" <?php if(!$securehosting_as) echo 'disabled="disabled"' ?> />
              <?php if ($error_as_referrer) { ?>
              <span class="error"><?php echo $error_as_referrer; ?></span>
              <?php } ?></td>
		  </tr>
		  <tr>
			  <td><?php echo $entry_sharedsecret; ?></td>
            <td><input type="text" name="securehosting_sharedsecret" value="<?php echo $securehosting_sharedsecret; ?>" /></td>
		  </tr>
		  <tr>
			  <td><?php echo $entry_test ?></td>
			  <td><select name="securehosting_test">
					  <?php if($securehosting_test){ ?>
					  <option value="1" selected="selected">Yes</option>
					  <option value="0">No</option>
					  <?php } else { ?>
					  <option value="1">Yes</option>
					  <option value="0" selected="selected">No</option>
					  <?php } ?>
				  </select></td>
		  </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="securehosting_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $securehosting_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="securehosting_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $securehosting_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="securehosting_status">
                <?php if ($securehosting_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="securehosting_sort_order" value="<?php echo $securehosting_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
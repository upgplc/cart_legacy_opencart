<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-secure-hosting" data-toggle="tooltip"
                        title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> Secure Hosting and Payments</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
                      id="form-secure-hosting" class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="securehosting_status" class="form-control">
                                <?php if ($securehosting_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_sort_order"><?php echo $entry_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="securehosting_sort_order"
                                   value="<?php echo $securehosting_sort_order; ?>" size="1"
                                   class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_shreference"><?php echo $entry_shreference; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="securehosting_shreference"
                                   value="<?php echo $securehosting_shreference; ?>" placeholder="SH200000"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_checkcode"><?php echo $entry_checkcode; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="securehosting_checkcode"
                                   value="<?php echo $securehosting_checkcode; ?>" placeholder=""
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_filename"><?php echo $entry_filename; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="securehosting_filename"
                                   value="<?php echo $securehosting_filename; ?>" placeholder=""
                                   class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="securehosting_as"><?php echo $entry_as; ?></label>
                        <div class="col-sm-10">
                            <select name="securehosting_as" class="form-control"
                                    onchange="this.form.securehosting_as_phrase.disabled = this.value == '0';this.form.securehosting_as_referrer.disabled = this.value == '0';">
                                <?php if($securehosting_as){ ?>
                                <option value="1" selected="selected">Yes</option>
                                <option value="0">No</option>
                                <?php } else { ?>
                                <option value="1">Yes</option>
                                <option value="0" selected="selected">No</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_as_phrase"><?php echo $entry_as_phrase; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="securehosting_as_phrase" <?php if(!$securehosting_as) echo 'disabled="disabled"' ?>
                                   value="<?php echo $securehosting_as_phrase; ?>" placeholder=""
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_as_referrer"><?php echo $entry_as_referrer; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="securehosting_as_referrer" <?php if(!$securehosting_as) echo 'disabled="disabled"' ?>
                                   value="<?php echo $securehosting_as_referrer; ?>" placeholder=""
                                   class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_test"><?php echo $entry_test; ?></label>
                        <div class="col-sm-10">
                            <select name="securehosting_test" class="form-control">
                                <?php if($securehosting_test){ ?>
                                <option value="1" selected="selected">Yes</option>
                                <option value="0">No</option>
                                <?php } else { ?>
                                <option value="1">Yes</option>
                                <option value="0" selected="selected">No</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="securehosting_geo_zone_id"><?php echo $entry_geo_zone; ?></label>
                        <div class="col-sm-10">
                            <select name="securehosting_geo_zone_id" class="form-control">
                                <option value="0"><?php echo $text_all_zones; ?></option>
                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                <?php if ($geo_zone['geo_zone_id'] == $securehosting_geo_zone_id) { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"
                                        selected="selected"><?php echo $geo_zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-order-status"><?php echo $entry_order_status; ?></label>
                        <div class="col-sm-10">
                            <select name="securehosting_order_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $securehosting_order_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"
                                        selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>

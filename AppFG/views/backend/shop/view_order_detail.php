<section class="content-header">
    <div class="content-header-left">
        <h1>Detail Order</h1>
    </div>
    <div class="content-header-right">
        <a href="#" class="btn btn-success btn-sm confirm_paid" data-paid="paid" data-amount="<?php echo number_format($order_detail['total'] > 1 && $order_detail['paid'] !== 'isPaid' ? $order_detail['total'] : "0.00", 2); ?>" data-order-number="<?php echo $order_detail['order_number']; ?>">Paid</a>
        <a href="#" class="btn btn-success btn-sm confirm_paid" data-paid="paid_update" data-amount="<?php echo number_format($order_detail['total_update'] > 1 && $order_detail['paid_update'] !== 'isPaid'  ? $order_detail['total_update'] : "0.00", 2); ?>" data-order-number="<?php echo $order_detail['order_number']; ?>">Update Paid</a>
        <a href="<?php echo base_url('backend/shop/order/update/' . $order_detail['order_id'] . '/' . $order_detail['order_number']); ?>" class="btn btn-danger">Order Edit</a>
        <a href="<?php echo base_url('backend/shop/order'); ?>" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="process_box" id="<?php echo $order_detail['status_process']; ?>">
        <!-- box box-info -->
        <div class="box box-info">
            <!-- invoice -->
            <div class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-eye"></i> IRISPICTURE, Inc.
                            <small class="pull-right">Date: <span id="f_u_date"><?php echo $order_detail['date_purchased']; ?></span></small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <p class="text-bold text-info">Invoice Address</p>
                        <address>
                            <p class="text-bold">Name: <?php echo $order_detail['billing_firstname'] . " " . $order_detail['billing_lastname']; ?></p>
                            <p><b>Phone:</b> <?php echo $order_detail['billing_phone']; ?></p>
                            <p><b>Email:</b> <?php echo $order_detail['billing_email']; ?></p>
                            <p><b>Notes:</b> <?php echo $order_detail['billing_comment']; ?></p>
                            <hr>
                            <p><b>Address:</b> <?php echo $order_detail['billing_street'] . "," . $order_detail['billing_postcode']; ?></p>
                            <p><b>City/Country:</b> <?php echo $order_detail['billing_city'] . " / " . $order_detail['billing_country']; ?></p>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <p class="text-bold text-info">Shipping Address</p>
                        <address>
                            <p class="text-bold">Name: <?php echo $order_detail['shipping_firstname'] . " " . $order_detail['shipping_lastname']; ?></p>
                            <p><b>Phone:</b> <?php echo $order_detail['shipping_phone']; ?></p>
                            <p><b>Email:</b> <?php echo $order_detail['shipping_email']; ?></p>
                            <p><b>Notes:</b> <?php echo $order_detail['shipping_comment']; ?></p>
                            <hr>
                            <p><b>Address:</b> <?php echo $order_detail['shipping_street'] . " " . $order_detail['shipping_postcode']; ?></p>
                            <p><b>City/Country:</b> <?php echo $order_detail['shipping_city'] . " / " . $order_detail['shipping_country']; ?></p>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <p class="text-bold">Order Number #<span id="f_u_order_number"><?php echo $order_detail['order_number']; ?></span></p>
                        <p class="text-bold">Security Number #<?php echo $order_detail['security_number']; ?></p>
                        <hr>
                        <p class="text-bold">Land Name: <span id="f_u_land_name"><?php echo $order_detail['land_name']; ?></span></p>
                        <p class="text-bold">Store Name: <span id="f_u_store_name"><?php echo $order_detail['store_name']; ?></span></p>
                        <p class="text-bold">Store ID: <span id="f_u_store_id"><?php echo $order_detail['store_id']; ?></span></p>
                        <hr>
                        <b>Order ID:</b> <?php echo $order_detail['order_id']; ?><br>
                        <b>Payment Method:</b> <?php echo $order_detail['payment_method']; ?><br>
                        <b>Payment Method Update:</b> <?php echo $order_detail['payment_method_update']; ?> <br>
                        <b>Paid:</b> <span id="f_u_paid"><?php echo $order_detail['paid']; ?></span> <br>
                        <b>Paid Update:</b> <?php echo $order_detail['paid_update']; ?><br>
                        <b>Status:</b> <?php echo $order_detail['status']; ?>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <hr>
                        <table class="content-table dataTable" id="table_product_items">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Item Price</th>
                                    <th>Is Updated</th>
                                    <th>Qty</th>

                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_item as $item) : ?>
                                    <tr style="background-color: rgb(151 199 222 / 40%); color: #000;">
                                        <td><input type="checkbox" class="is_printed" data-type="normal" data-item-id="<?php echo $item['item_product_id']; ?>" <?php echo $item['is_printed'] == 1 ? 'checked' : ''; ?>> 
                                        <?php echo $item['item_name']; ?> (<?php echo $item['item_product_id']; ?>)
                                        <?php echo $item['comment'] != NULL ? "Address: ".$item['comment'] : "" ;?>
                                    </td>
                                        <td><?php echo $item['item_price']; ?></td>
                                        <td>current</td>
                                        <td><?php echo $item['item_qty']; ?></td>

                                        <td><?php echo $item['item_currency_icon']; ?> <?php echo $item['item_subtotal']; ?></td>
                                        <td><span class="pull-right">
                                                <?php echo $item['created_at']; ?>
                                                <?php if (in_array($this->session->userdata('role'), ['Superadmin'])) : ?> - <a href="<?php echo base_url('backend/shop/order/delete_order_item/' . $item['item_id'] . '/' . $item['order_number']); ?>"><i class="fa fa-trash text-danger"></i></a>
                                                <?php endif; ?> - 
                                                <?php echo $item['is_completed'] == 1 ? '<i class="fa fa-check success" data-toggle="tooltip" data-placement="left" title="done"></i>' : '<i class="fa fa-times error" data-toggle="tooltip" data-placement="left" title="not done"></i>';?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php foreach ($order_item_updated as $item_updated) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="is_printed" data-type="update" data-item-id="<?php echo $item_updated['item_id']; ?>" <?php echo $item_updated['is_printed'] == 1 ? 'checked' : ''; ?>> <?php echo $item_updated['item_name']; ?> <?php echo $item_updated['item_id']; ?> => <?php echo $item_updated['item_id_old']; ?></td>
                                        <td><?php echo $item_updated['item_price']; ?></td>
                                        <td><?php echo $item_updated['is_updated']; ?></td>
                                        <td><?php echo $item_updated['item_qty']; ?></td>

                                        <td><?php echo $item_updated['item_currency_icon']; ?> <?php echo $item_updated['item_subtotal']; ?></td>
                                        <td><span class="pull-right">
                                                <?php echo $item_updated['created_at']; ?>
                                                <?php if (in_array($this->session->userdata('role'), ['Superadmin'])) : ?> - <a href="<?php echo base_url('backend/shop/order/delete_order_item/' . $item_updated['item_id'] . '/' . $item_updated['order_number']); ?>"><i class="fa fa-trash text-danger"></i></a>
                                                <?php endif; ?>
                                            </span></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->

                    <div class="col-md-8">
                        <div class="row">

                            <div id="exTab3">
                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#1b" data-toggle="tab">FOR PHOTOSHOP</a>
                                    </li>
                                    <li><a href="#2b" data-toggle="tab">FOR PRINTING</a></li>
                                    <li><a href="#3b" data-toggle="tab">NOTES</a></li>
                                    <li><a href="#4b" data-toggle="tab">CONFIRM</a></li>
                                </ul>

                                <div class="tab-content clearfix">
                                    <!--- for photoshop  start -->
                                    <div class="tab-pane active" id="1b">
                                        <?php
                                        $with_name_price = 0;
                                        foreach ($order_item_upload as $item_upload) :
                                            $with_name_price += $item_upload["with_name_price"];
                                            $item_img_explode = explode('.', $item_upload["image"]);
                                            if (strtoupper($item_img_explode[1]) !== "CR2") :
                                        ?>
                                                ​
                                                <div class="col-md-6">
                                                    <div class="polaroid">
                                                        <div class="relative_img">
                                                            <a href="<?php echo base_url($item_upload["path"] . $item_upload["image"]); ?>" data-toggle="lightbox" data-gallery="for-photoshop-gallery">
                                                                <img class="img-responsive" width="100%" height="250" src="<?php echo base_url($item_upload["path"] . $item_upload["image"]); ?>" data-toggle="tooltip" data-placement="bottom" title="name: <?php echo $item_upload["with_name"]; ?> - Price: <?php echo $item_upload["with_name_price"]; ?>  - item id: <?php echo $item_upload["item_id"]; ?>">
                                                            </a>
                                                            <div class="is_extra">
                                                                <?php if ($item_upload["is_extra"] == 1) : ?>
                                                                    <small class="label bg-red">Extra</small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="is_selected">
                                                                <?php if ($item_upload["is_selected"] == 1) : ?>
                                                                    <small class="label bg-green">Selected</small>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <p class="mt-10">
                                                            <span class="text-yellow"> item id: <?php echo $item_upload["item_id"]; ?> <?php echo $item_upload["item_id_duplicated"] != 0 ? '- Duplicated' : ''; ?></span><br>
                                                            <span class="text-yellow"> item id old : <?php echo $item_upload["item_id_duplicated"]; ?></span><br>
                                                            <span class="text-green">Owner: <?php echo $item_upload["image_owner"]; ?></span> <br>
                                                            <span class="text-blue">Text: <?php echo $item_upload["with_name"]; ?></span> <br>
                                                            <span class="text-danger">Price: <?php echo number_format($item_upload["with_name_price"], 2); ?></span> <br>
                                                            <span class="text-danger">Total: <?php echo number_format($item_upload["total"], 2); ?></span> <br>
                                                            <?php echo $item_upload['image_dublicated_name'] !== NULL ? $item_upload['image_dublicated_name'] : $item_upload["image"]; ?>
                                                        </p>

                                                    </div>
                                                </div>

                                        <?php endif;
                                        endforeach; ?>

                                        <div class="col-md-12">
                                            <a href="#" data-order-number="<?php echo $order_detail['order_number']; ?>" class="btn btn-block btn-primary mt-20 photoshop_download">
                                                Download All Images
                                            </a>
                                        </div>

                                    </div><!-- tabe-pane end 1b -->
                                    <!--- for photoshop  end -->
                                    <!--- for printer  start -->
                                    <div class="tab-pane" id="2b">
                                        <div id="uploaded_images">
                                            <?php foreach ($order_item_upload_done as $row_done_img) : ?>
                                                <div class="col-md-6" id="done_img_<?php echo $row_done_img['image_id']; ?>">
                                                    <div class="polaroid">
                                                        <div class="relative_img">
                                                            <a href="<?php echo base_url() . $row_done_img["path"] . $row_done_img["image"]; ?>" data-toggle="lightbox" data-gallery="for-printer-gallery">
                                                                <img class="img-responsive" width="100%" height="250" src="<?php echo base_url() . $row_done_img["path"] . $row_done_img["image"]; ?>">
                                                            </a>
                                                            <div class="is_extra">
                                                                <small class="label bg-blue">Upload by <?php echo $row_done_img['user']; ?></small>
                                                            </div>
                                                            <div class="is_selected">
                                                                <small class="label bg-yellow"><?php echo date("d-m-Y", strtotime($row_done_img['created_at'])); ?></small>
                                                            </div>
                                                            <div class="order_img_delete">
                                                                <small class="label bg-red"><i class="fa fa-trash photoshop_delete" data-id="<?php echo $row_done_img['image_id']; ?>"></i></small>
                                                            </div>
                                                            <div class="order_img_download">
                                                                <small class="label bg-green"><i class="fa fa-download photoshop_download" data-id="<?php echo $row_done_img['image_id']; ?>"></i></small>
                                                            </div>
                                                        </div>
                                                        <span style="overflow: hidden;"><?php echo $row_done_img['image']; ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="file" id='photos' name="photos[]" accept="image/* , application/tif" class="bg-red" style="display:block;width:100%;padding:10px" multiple /><br>
                                            <button id="photoshop_upload" class="btn btn-block btn-primary mt-20">Upload</button>
                                        </div>
                                    </div><!-- tabe-pane end 2b -->
                                    <!--- for printer  end -->
                                    <!--- for notes  start -->
                                    <div class="tab-pane" id="3b">
                                        <p>NOTES</p>
                                        <hr>
                                        <div id="all_order_notes">
                                            <?php foreach ($get_order_note as $row_note) : ?>
                                                <div class="callout callout-info" id="note_id_<?php echo $row_note['id']; ?>">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border">
                                                            <p><?php echo in_array($this->session->userdata('role'), ["Superadmin"]) ? '<i class="fa fa-trash delete_order_note" data-note-id="' . $row_note['id'] . '"></i>' : ''; ?> <span class="pull-right"><?php echo $row_note['user']; ?> - <?php echo $row_note['created_at']; ?></span></p>
                                                        </div>
                                                        <div class="box-body text-black">
                                                            <?php echo $row_note['note']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <textarea id="editor2" class="order_note_text"></textarea>
                                        <button class="btn btn-block btn-primary add_oder_note">Add Note</button>
                                    </div><!-- tabe-pane end 3b -->
                                    <!--- for notes  end -->
                                    <!--- for notes  start -->
                                    <div class="tab-pane" id="4b">
                                        <p>FREIGABE</p>
                                        <?php foreach ($get_order_customer_process as $row_freigabe) : ?>
                                            <?php if (!empty($row_freigabe['comment'])) : ?>
                                                <div class="callout callout-<?php echo $row_freigabe['freigabe'] == 1 ? 'info' : 'danger'; ?>">
                                                    <div class="box box-default">
                                                        <div class="box-header with-border">
                                                            <p>Freigabe:<?php echo $row_freigabe['freigabe'] == 1 ? 'Verildi.' : 'Verilmedi'; ?> <span class="pull-right">Customer - <?php echo $row_freigabe['created_at']; ?></span></p>
                                                        </div>
                                                        <div class="box-body text-black">
                                                            <?php echo $row_freigabe['comment']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div><!-- tabe-pane end 3b -->
                                    <!--- for notes  end -->
                                </div>
                            </div>
                        </div><!-- row end -->
                    </div><!-- col-8 end -->

                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $order_detail['total']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>With Name Price:</th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo $with_name_price != 0 ? number_format($with_name_price, 2) : '0.00'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <th>Order subtotal:</th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($o_zwischensumme, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order ready paid: </th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($o_bereit_bezahlt, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order to pay: </th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($o_zu_zahlen, 2); ?></td>
                                    </tr>

                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <th>Update subtotal:</th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($u_zwischensumme, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Update ready paid: </th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($u_bereit_bezahlt, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Update to pay: </th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($u_zu_zahlen, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <th>To pay in total: </th>
                                        <td><?php echo $order_detail['store_currency_icon']; ?> <?php echo number_format($zahlen, 2); ?></td>
                                    </tr>

                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <?php foreach ($get_order_paid_process as $row_order_paid_process) : ?>
                                        <?php if ($row_order_paid_process['type_paid'] === 'paid' && $row_order_paid_process['amount'] > 1) : ?>
                                            <tr>
                                                <th>Paid:</th>
                                                <td><?php echo $order_detail['store_currency_icon'] . " " . number_format($row_order_paid_process['amount'], 2); ?> <?php echo $row_order_paid_process['user']; ?> </td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php if ($row_order_paid_process['type_paid'] === 'paid_update' && $row_order_paid_process['amount'] > 1) : ?>
                                            <tr>
                                                <th>Paid Update:</th>
                                                <td><?php echo $order_detail['store_currency_icon'] . " " . number_format($row_order_paid_process['amount'], 2); ?> <?php echo $row_order_paid_process['user']; ?> </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- invoice end -->
        </div>
        <!-- box box-info end -->
    </div>
    <!-- process end -->


</section>

<section class="content">
    <div class="order_process" data-order-number="<?php echo $order_detail['order_number']; ?>">
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="1" class="status_process process-view-order">View Order</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="2" class="status_process process-photographed-light">photographed</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="3" class="status_process process-photographed-dark">fullphotographed</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="4" class="status_process process-in-photoshop">in-photoshop</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="5" class="status_process process-finished-photoshop">finished-photoshop</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="6" class="status_process process-customer-confirmed">customer-confirmed</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="7" class="status_process process-finished-photoshop-data">finished-photoshop-data</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="8" class="status_process process-printed">printed</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="9" class="status_process process-shipped">shipped</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="10" class="status_process process-urgent">urgent</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="11" class="status_process process-incorrect">incorrect</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="12" class="status_process process-could-not-be-done">Can't be done</a></div>
        <?php endif; ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div data-status-process="13" class="status_process process-not-confirm">Not Confirm</a></div>
        <?php endif; ?>
    </div>
</section>
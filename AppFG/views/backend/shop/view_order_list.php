<section class="content-header">
    <div class="order_process">
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="1 process-view-order"><a href="<?php echo base_url('backend/shop/order/index/1'); ?>">View Order <br> [ <?php echo $count_status_process[0][1]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="2 process-photographed-light"><a href="<?php echo base_url('backend/shop/order/index/2'); ?>">photographed <br> [ <?php echo $count_status_process[1][2]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="3 process-photographed-dark"><a href="<?php echo base_url('backend/shop/order/index/3'); ?>">fullphotographed <br> [ <?php echo $count_status_process[2][3]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="4 process-in-photoshop"><a href="<?php echo base_url('backend/shop/order/index/4'); ?>">in-photoshop <br> [ <?php echo $count_status_process[3][4]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="5 process-finished-photoshop"><a href="<?php echo base_url('backend/shop/order/index/5'); ?>">finished-photoshop <br> [ <?php echo $count_status_process[4][5]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="6 process-customer-confirmed"><a href="<?php echo base_url('backend/shop/order/index/6'); ?>">customer-confirmed <br> [ <?php echo $count_status_process[5][6]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="7 process-finished-photoshop-data"><a href="<?php echo base_url('backend/shop/order/index/7'); ?>">finished-photoshop-data <br> [ <?php echo $count_status_process[6][7]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="8 process-printed"><a href="<?php echo base_url('backend/shop/order/index/8'); ?>">printed <br> [ <?php echo $count_status_process[7][8]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="9 process-shipped"><a href="<?php echo base_url('backend/shop/order/index/9'); ?>">shipped <br> [ <?php echo $count_status_process[8][9]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="10 process-urgent"><a href="<?php echo base_url('backend/shop/order/index/10'); ?>">urgent <br> [ <?php echo $count_status_process[9][10]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="11 process-incorrect"><a href="<?php echo base_url('backend/shop/order/index/11'); ?>">incorrect <br> [ <?php echo $count_status_process[10][11]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="12 process-could-not-be-done"><a href="<?php echo base_url('backend/shop/order/index/12'); ?>">Can't be done <br> [ <?php echo $count_status_process[11][12]; ?> ]</a></div>
        <?php endif ?>
        <?php if (in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) : ?>
            <div class="13 process-not-confirm"><a href="<?php echo base_url('backend/shop/order/index/13'); ?>">Not Confirm Order <br> [ <?php echo $count_status_process[12][13]; ?> ]</a></div>
        <?php endif ?>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('error')) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            <?php endif; ?>

            <div class="process_box">
                <div class="box">
                    <div class="box-body table-responsive">
                        
                        <table id="example1" class="content-table">
                            <thead>
                                <tr>
                                    <th width="10">ID</th>
                                    <th width="20">From</th>
                                    <th width="10">Order Number</th>
                                    <th width="70">Customer name</th>
                                    <th width="80">Customer Address</th>
                                    <th width="70">Email</th>
                                    <th width="80">Total</th>
                                    <th width="80">Paid</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $row) : ?>
                                    <tr>
                                        <td><?php echo $row['order_id']; ?></td>
                                        <td><?php echo $row['order_type']; ?></td>
                                        <td><?php echo $row['order_number']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('backend/shop/order/detail/' . $row['order_id'] . '/' . $row['order_number']); ?>"><?php echo $row['billing_firstname'] . " " . $row['billing_lastname']; ?><br />
                                                <?php echo $row['billing_email']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url('backend/shop/order/detail/' . $row['order_id'] . '/' . $row['order_number']); ?>">
                                                <?php echo $row['billing_street']; ?>, <?php echo $row['billing_postcode']; ?><br> <?php echo $row['billing_city']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $row['billing_email']; ?></td>
                                        <td><?php echo $row['total']; ?></td>
                                        <td><?php echo $row['paid']; ?></td>
                                        <td>
                                        <?php echo $row['date_purchased']; ?>
                                            <br />
                                            <a href="#" class="labelprint" data-order-number="<?php echo $row['order_number']; ?>" data-security-number="<?php echo $row['security_number']; ?>" data-expiry-date="<?php echo date('d-m-Y', strtotime('+1 year', strtotime($row['date_purchased']))); ?>"><i class="fa fa-2x fa-barcode"></i></a>
                                            <a href="<?php echo base_url('public/pdf/invoice/' . $row['order_number'] . '.pdf'); ?>" title="Order Confirmation" target="_blank"><i class="fa fa-2x fa-file-pdf"></i></a>
                                            <a href="<?php echo base_url('public/pdf/coupon/' . $row['order_number'] . '.pdf'); ?>" title="Shooting-Voucher Coupon" target="_blank"><i class="fa fa-2x fa-tag"></i></a>
                                            <a href="#" data-lang-code="<?php echo $row['store_lang_code']; ?>" data-message-type="<?php echo $row['payment_method'] === 'bankTransfer' ? 'bankTransfer' : 'mollie'; ?>" data-email="<?php echo $row['billing_email']; ?>" data-order-number="<?php echo $row['order_number']; ?>" title="Send e mail again"><i class="fa fa-2x fa-envelope re_send_email"></i></a>
                                            <?php if (in_array($this->session->userdata('role'), ['Superadmin'])) : ?>
                                                <a href="<?php echo base_url(); ?>backend/shop/order/delete/<?php echo $row['order_id']; ?>/<?php echo $row['order_number']; ?>" class="text-danger" onClick="return confirm('Are you sure?');"><i class="fa fa-2x fa-trash"></i></a>
                                            <?php endif; ?>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- #box -->
            </div><!-- #box process -->
        </div>
    </div>
</section>

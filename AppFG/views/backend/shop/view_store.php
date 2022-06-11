<section class="content-header">
    <div class="content-header-left">
        <h1>View Stores</h1>
    </div>
    <div class="content-header-right">
        <a href="<?php echo base_url(); ?>backend/shop/store/add" class="btn btn-primary btn-sm">Add Store</a>
        <a href="<?php echo base_url(); ?>backend/shop/store/add_value" class="btn btn-primary btn-sm">Add Store Value</a>
        <a href="<?php echo base_url(); ?>backend/shop/store/value" class="btn btn-primary btn-sm">All Store Value</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php
            if ($this->session->flashdata('error')) {
                ?>
                <div class="callout callout-danger">
                    <p><?php echo $this->session->flashdata('error'); ?></p>
                </div>
                <?php
            }
            if ($this->session->flashdata('success')) {
                ?>
                <div class="callout callout-success">
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
                <?php
            }
            ?>


            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="content-table dataTable">
                        <thead>
                        <tr>
                            <th width="30">SL</th>
                            <th width="70">Photo</th>
                            <th>Land Name</th>
                            <th>Store Name</th>
                            <th width="110">Currency Code</th>
                            <th width="110">Currency Icon</th>
                            <th width="100">Lang Code</th>
                            <th width="100">Tax</th>
                            <th width="100">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($store as $row): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td style="width:130px;">
                                    <?php if(!empty($row['photo'])):?>
                                    <img
                                            src="<?php echo base_url(); ?>public/uploads/store_photos/<?php echo $row['photo']."?v=".time(); ?>"
                                            style="width:120px;">
                                    <?php endif;?>
                                </td>
                                <td><?php echo $row['land_name']; ?></td>
                                <td><?php echo $row['store_name']; ?></td>
                                <td><?php echo $row['currency_code']; ?></td>
                                <td><?php echo $row['currency_icon']; ?></td>
                                <td><?php echo $row['lang_code']; ?></td>
                                <td><?php echo $row['tax']; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>backend/shop/store/edit/<?php echo $row['id']; ?>"
                                       class="btn btn-primary btn-xs">Edit</a>
                                    <a href="<?php echo base_url(); ?>backend/shop/store/delete/<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-xs"
                                       onClick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</section>
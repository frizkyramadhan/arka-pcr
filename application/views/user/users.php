<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-user"></i>
                        <h3>User Lists</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <h4><span style="float: right"><a href="<?php echo site_url('user/add'); ?>" class="btn btn-success">+ Add User</a></span></h4><br><br>
                        <div class="form-horizontal">
                        <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div align="center">No</div></th>
                                    <th><div align="center">Username</div></th>
                                    <th><div align="center">Password</div></th>
                                    <th><div align="center">Level</div></th>
                                    <th><div align="center">Project</div></th>
                                    <th><div align="center">Sign</div></th>
                                    <th><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $i=1; ?>
                                    <?php foreach ($users as $row): ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><div align="center"><?php echo $row->username; ?></div></td>
                                    <td><div align="center">********</div></td>
                                    <td><div align="center"><?php echo $row->level; ?></div></td>
                                    <td><div align="center"><?php echo $row->kode_project; ?> - <?php echo $row->nama_project; ?></div></td>
                                    <td><div align="center"><?php echo $row->sign; ?></div></td>
                                    <td>
                                        <div align="center">
                                            <a href="<?php echo base_url('user/edit/'.$row->id_user); ?>" class="btn btn-mini btn-info">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
                                        <a href="<?php echo base_url('user/delete/'.$row->id_user); ?>" class="btn btn-mini btn-danger" onclick="return confirm('Are you want to delete this user?')">Delete</a>    
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                        </div>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
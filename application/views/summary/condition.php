<?php $conn = mysqli_connect('localhost', 'root', '@rk@*', 'arka_pcr')?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-columns"></i>
                        <h3>Component Condition Summary</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <form class="form-inline" method="POST">
                            <div class="control-group">
                                <div class="controls" align="center">
                                    <div class="accordion" id="accordion2">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                                    <div align="center">-- Advance Filter --</div>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="accordion-body collapse">
                                                <div class="accordion-inner">
                                                    <table>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="siteCat"> Project</label></td>
                                                            <td>
                                                                <label class="checkbox inline">
                                                                    <!--<input type="text" name="kode_project">-->
                                                                    <?php
                                                                    echo form_dropdown('kode_project', $proj_options, '');
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="unitCat"> Unit No</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_no"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="modelCat"> Model</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="model_no"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat"> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="condCat"> Condition</label></td>
                                                            <td>
                                                                <label class="checkbox inline">
                                                                    <?php $options = array('NORMAL'=>'NORMAL','ATTENTION'=>'ATTENTION','CRITICAL'=>'CRITICAL');
                                                                    echo form_dropdown('condition', $options, '');?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr><td></td><td><div align="center"><label class="checkbox inline"><input class="btn btn-info" type="submit" name="submit" value="Submit"> <input class="btn" type="reset" name="reset" value="&nbsp;Reset&nbsp;"></label></td></tr>
                                                     </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                        </form>
                            <?php
                                $bagianWhere = "";
                                if (isset($_POST['siteCat'])){
                                   $project = $_POST['kode_project'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "kode_project LIKE '$project'";
                                   }else{
                                        $bagianWhere .= " AND kode_project LIKE '$project'";
                                   }
                                }
                                if (isset($_POST['unitCat'])){
                                   $unit = $_POST['unit_no'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "unit_no LIKE '%$unit%'";
                                   }else{
                                        $bagianWhere .= " AND unit_no LIKE '%$unit%'";
                                   }
                                }
                                if (isset($_POST['compCat'])){
                                   $comp = $_POST['comp_desc'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "comp_desc LIKE '%$comp%'";
                                   }else{
                                        $bagianWhere .= " AND comp_desc LIKE '%$comp%'";
                                   }
                                }
                                if (isset($_POST['modelCat'])){
                                   $model = $_POST['model_no'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "model_no LIKE '%$model%'";
                                   }else{
                                        $bagianWhere .= " AND model_no LIKE '%$model%'";
                                   }
                                }
                                if (isset($_POST['condCat'])){
                                   $cond = $_POST['condition'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "cd.condition LIKE '%$cond%'";
                                   }else{
                                        $bagianWhere .= " AND cd.condition LIKE '%$cond%'";
                                   }
                                }
                            ?>
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Status Filter: <?php echo $bagianWhere;?>
                        </div>
                        
                        <form action="condition/export" method="POST">
                            <?php
                            if (empty($bagianWhere)){
                                $where = 1;
                            }else{
                                $where = $bagianWhere;
                            }
//                            ?>
                            <input type="hidden" name="where" value="<?php echo $where ?>" >
                            <div align="center"><input type="submit" value="Export to Excel" class="btn btn-success" ></div>
                        </form>
                        
                            <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td><div align="center"><strong>No</strong></div></td>
                                    <td><div align="center"><strong>Site</strong></div></td>
                                    <td><div align="center"><strong>Unit No.</strong></div></td>
                                    <td><div align="center"><strong>Model</strong></div></td>
                                    <td><div align="center"><strong>Component Description</strong></div></td>
                                    <td><div align="center"><strong>Component Condition</strong></div></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $i=1;?>
                                    <?php 
                                    $condition = 
                                            "SELECT * FROM arka_pcr.condition cd
                                            LEFT JOIN unit u ON cd.id_unit = u.id_unit
                                            LEFT JOIN commod cm ON cd.id_mod = cm.id_mod
                                            LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                                            LEFT JOIN project p ON u.id_project = p.id_project
                                            LEFT JOIN comp c ON cm.id_comp = c.id_comp
                                            WHERE ".$bagianWhere."
                                            ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC
                                            ";
                                    $hasil = mysqli_query($conn,$condition);
                                    ?>
                                    <?php if (empty($hasil)):?>
                                    <td colspan="6"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php while ($row = mysqli_fetch_array($hasil)):?>
                                    <?php
                                    $warna = "";
                                    if ($row['condition'] == "NORMAL"){
                                        $warna = "#00ff00";
                                    } elseif ($row['condition'] == "ATTENTION") {
                                        $warna = "#ff9900";
                                    } elseif ($row['condition'] == "CRITICAL") {
                                        $warna = "#ff0000";
                                    }
                                    ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><div align="center"><?php echo $row['kode_project']; ?></div></td>
                                    <td><div align="center"><?php echo $row['unit_no']; ?></div></td>
                                    <td><div align="center"><?php echo $row['model_no']; ?></div></td>
                                    <td><div align="center"><?php echo $row['comp_desc']; ?></div></td>
                                    <td bgcolor=<?php echo $warna; ?>><div align="center"><b><?php echo $row['condition']; ?></b></div></td>
                                </tr>
                                <?php endwhile;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                       <!-- <pre>
                        <?php print_r($condition);?><br>
                        </pre> -->
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
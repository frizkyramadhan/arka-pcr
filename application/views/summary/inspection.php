<?php $conn = mysqli_connect('localhost', 'root', '', 'arka_pcr')?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-columns"></i>
                        <h3>Inspection Summary</h3>
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
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat"> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="ratingCat"> Rating</label></td>
                                                            <td>
                                                                <label class="checkbox inline">
                                                                    <?php $options = array('A'=>'A','B'=>'B','C'=>'C','X'=>'X');
                                                                    echo form_dropdown('rating', $options, '');?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="typeCat"> Type</label></td>
                                                            <td>
                                                                <label class="checkbox inline">
                                                                    <?php $type_options = array('FC'=>'Filter Cut','MPS'=>'Magnetic Plug/Screen','VI'=>'Visual Inspection','TA2'=>'Techical Analysis 2','ED'=>'Electronic Data');
                                                                    echo form_dropdown('type', $type_options, '');?>
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
                                if (isset($_POST['ratingCat'])){
                                   $rating = $_POST['rating'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "rating LIKE '%$rating%'";
                                   }else{
                                        $bagianWhere .= " AND rating LIKE '%$rating%'";
                                   }
                                }
                                if (isset($_POST['typeCat'])){
                                   $type = $_POST['type'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "type LIKE '%$type%'";
                                   }else{
                                        $bagianWhere .= " AND type LIKE '%$type%'";
                                   }
                                }
                            ?>
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Status Filter: <?php echo $bagianWhere;?>
                        </div>
                        
                        <form action="inspection/export" method="POST">
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
                                    <td><div align="center"><strong>Inspection Date</strong></div></td>
                                    <td><div align="center"><strong>Unit No.</strong></div></td>
                                    <td><div align="center"><strong>Component Description</strong></div></td>
                                    <td><div align="center"><strong>Hour Meter</strong></div></td>
                                    <td><div align="center"><strong>Rating</strong></div></td>
                                    <td><div align="center"><strong>Type</strong></div></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php $i=1;?>
                                    <?php 
                                    $inspection = 
                                            "SELECT * 
                                                FROM inspection s 
                                                LEFT JOIN unit u ON s.id_unit = u.id_unit
                                                LEFT JOIN commod cm ON s.id_mod = cm.id_mod
                                                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                                                LEFT JOIN project p ON u.id_project = p.id_project
                                                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                                                WHERE ".$bagianWhere."
                                                ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, s.id_ins DESC";
                                    $hasil = mysqli_query($conn,$inspection);
                                    ?>
                                    <?php if (empty($hasil)):?>
                                    <td colspan="7"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php while ($row = mysqli_fetch_array($hasil)):?>
                                    <?php
                                    $warna = "";
                                    if ($row['rating'] == "A"){
                                        $warna = "#00ff00";
                                    } elseif ($row['rating'] == "B") {
                                        $warna = "#ffff00";
                                    } elseif ($row['rating'] == "C") {
                                        $warna = "#ff9900";
                                    } elseif ($row['rating'] == "X") {
                                        $warna = "#ff0000";
                                    }
                                    ?>
                                    <td><div align="center"><?php echo $i++; ?></div></td>
                                    <td><div align="center"><?php echo $row['kode_project']; ?></div></td>
                                    <td><div align="center"><?php echo $row['ins_date']; ?></div></td>
                                    <td><div align="center"><?php echo $row['unit_no']; ?></div></td>
                                    <td><div align="center"><?php echo $row['comp_desc']; ?></div></td>
                                    <td><div align="center"><?php echo $row['ins_hm']; ?></div></td>
                                    <td bgcolor=<?php echo $warna; ?>><div align="center"><b><?php echo $row['rating']; ?></b></div></td>
                                    <td><div align="center"><?php echo $row['type']; ?></div></td>
                                </tr>
                                <?php endwhile;?>
                                <?php endif;?>
                            </tbody>
                        </table>
<!--                        <pre>
                        <?php // print_r($pcr);?><br>
                        <?php // print_r($bagianWhere);?>
                        </pre>-->
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
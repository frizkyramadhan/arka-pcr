<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <i class="icon-tint"></i>
                            <h3>Add Sampling</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <h4><span style="float: left"><a href="<?php echo site_url('unit/sos/'.$mod->id_unit.'/'.$mod->id_mod); ?>" class="btn btn-info"><i class="icon-arrow-left"></i>&nbsp;&nbsp;Back</a></span></h4><br><br>
                            <div class="form-horizontal">
                                <!--<pre><?php // print_r($hm);?></pre>-->
                                <table cellspacing="0" width="100%">
                                    <tr>
                                        <td>Unit No.</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_no?></b></td>
                                        <td>Model</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->model_no?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Unit Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->unit_desc?></b></td>
                                        <td>Component Description</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->comp_desc?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->kode_project?> | <?php echo $mod->nama_project?></b></td>
                                        <td>Policy</td>
                                        <td>:</td>
                                        <td><b><?php echo $mod->policy?></b></td>
                                    </tr>
                                </table>
                               
                                <hr>
                                <form class="form-horizontal" role="form" action="" method="post">
                                    <fieldset>
                                        <div class="span5">
                                            <input type="hidden" class="span3" name="id_unit" value="<?php echo $mod->id_unit; ?>"/>
                                            <input type="hidden" class="span3" name="id_mod" value="<?php echo $mod->id_mod; ?>"/>
                                            <div class="control-group">											
                                                <label class="control-label">Sample Date</label>
                                                <div class="controls">
                                                    <input type="text" id="rep_date" class="span3" name="sample_date"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Laboratory Name</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="lab_name"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Laboratory No.</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="lab_no"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Oil Type</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="oil_type"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                        </div>
                                        <div class="span5">
                                            <div class="control-group">											
                                                <label class="control-label">Hours Oil</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="h_oil"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Hours Unit</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="h_unit"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Oil Change</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="oil_change"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                            <div class="control-group">											
                                                <label class="control-label">Oil Added</label>
                                                <div class="controls">
                                                    <input type="text" class="span3" name="oil_added"/>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                        </div>
                                    </fieldset>
                                    <hr>
                                    <fieldset>
                                        <div class="span12">
                                            <div class="control-group">											
                                                <label class="control-label">Evaluation Code</label>
                                                <div class="controls">
                                                    <?php $options = array(
                                                      'A'  => 'A',
                                                      'B'  => 'B',
                                                      'C'  => 'C',
                                                      'D'  => 'D',
                                                      'X'  => 'X',
                                                      'Normal'  => 'Normal',
                                                      'Attention'  => 'Attention',
                                                      'Urgent'  => 'Urgent'
                                                    );
                                                    echo form_dropdown('eval_code', $options, 'A', 'class=span3');
                                                    ?>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                        </div>
                                        <div class="span12">
                                            <div class="control-group">											
                                                <label class="control-label">Recommendation</label>
                                                <div class="controls">
                                                    <textarea name="recommendation" rows="2" cols="20" class="span8"></textarea>
                                                </div> <!-- /controls -->				
                                            </div> <!-- /control-group -->
                                        </div>
                                    </fieldset>
<!--                                    <fieldset>
                                        <div align="center"><b>Element Sample</b></div>
                                        <table class="table table-condensed" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <td><div align="center"><strong>Fe</strong></div></td>
                                                    <td><div align="center"><strong>Cu</strong></div></td>
                                                    <td><div align="center"><strong>Cr</strong></div></td>
                                                    <td><div align="center"><strong>Si</strong></div></td>
                                                    <td><div align="center"><strong>Al</strong></div></td>
                                                    <td><div align="center"><strong>Ni</strong></div></td>
                                                    <td><div align="center"><strong>Sn</strong></div></td>
                                                    <td><div align="center"><strong>Pb</strong></div></td>
                                                    <td><div align="center"><strong>PQ</strong></div></td>
                                                    <td><div align="center"><strong>Soot</strong></div></td>
                                                    <td><div align="center"><strong>Oxid</strong></div></td>
                                                    <td><div align="center"><strong>Nitr</strong></div></td>
                                                    <td><div align="center"><strong>SOX</strong></div></td>
                                                    <td><div align="center"><strong>4um</strong></div></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="fe"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="cu"><div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="cr"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="si"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="al"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="ni"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="sn"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="pb"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="pq"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="soot"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="oxid"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="nitr"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="sox"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="4um"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </fieldset>
                                        <fieldset>
                                        <table class="table table-condensed" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <td><div align="center"><strong>6um</strong></div></td>
                                                    <td><div align="center"><strong>14um</strong></div></td>
                                                    <td><div align="center"><strong>15um</strong></div></td>
                                                    <td><div align="center"><strong>ISO4406</strong></div></td>
                                                    <td><div align="center"><strong>ISO.14</strong></div></td>
                                                    <td><div align="center"><strong>ISO.6</strong></div></td>
                                                    <td><div align="center"><strong>Ca</strong></div></td>
                                                    <td><div align="center"><strong>Zn</strong></div></td>
                                                    <td><div align="center"><strong>Mo</strong></div></td>
                                                    <td><div align="center"><strong>Bo</strong></div></td>
                                                    <td><div align="center"><strong>P</strong></div></td>
                                                    <td><div align="center"><strong>Na</strong></div></td>
                                                    <td><div align="center"><strong>K</strong></div></td>
                                                    <td><div align="center"><strong>Mg</strong></div></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="6um"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="14um"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="15um"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="iso4406"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="iso14"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="iso6"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="ca"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="zn"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="mo"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="bo"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="p"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="na"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="k"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="mg"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                    <fieldset>
                                        <table class="table table-condensed" cellspacing="0" width="100%" style="display: block; overflow-x: auto">
                                            <thead>
                                                <tr>
                                                    <td><div align="center"><strong>Visc</strong></div></td>
                                                    <td><div align="center"><strong>TBN</strong></div></td>
                                                    <td><div align="center"><strong>TAN</strong></div></td>
                                                    <td><div align="center"><strong>Gly</strong></div></td>
                                                    <td><div align="center"><strong>WATER</strong></div></td>
                                                    <td><div align="center"><strong>DILUTION</strong></div></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="visc"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="tbn"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="tan"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="gly"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="water"></div></td>
                                                    <td><div align="center"><input type="text" class="span1" style="text-align:right;" name="dilution"></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>-->
                                    <fieldset>   
                                        <div class="form-actions span9">
                                            <button type="submit" class="btn btn-primary">Save</button> 
                                            <button type="reset"class="btn">Reset</button>
                                        </div> <!-- /form-actions -->
                                    </fieldset>
                                </form>
                            </div>
                        </div> <!-- /widget-content -->	
                    </div> <!-- /widget -->					
		</div> <!-- /span12 -->     	
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
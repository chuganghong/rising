                       
                   <div class="pageRcon">
                   		<div class="brand marginbot">                        	
							<?php foreach($brand as $k=>$v): ?>
                            <span class="brand<?php echo $k; ?>"><img src="<?php echo $pre . $v['img_src']; ?>" /></span>
                            <div class="showdetail">
                            	 <div class="showdetail_con">
                            	 <strong><?php echo $v['img_title']; ?></strong>
								 <p><?php echo $v['img_alt_tw']; ?></p>
								</div>
                                <div class="showdetail_wrap"></div>
                            </div>
							<?php endforeach; ?>							
                        </div>
                        <div class="zuopinwrap">
                        <?php foreach($cases as $k=>$v):
						if($k==0)
						{
							continue;
						}
						?>
						
                            <div class="zuopin zuopinm" style="z-index:2">
							<?php foreach($v as $vv): ?>
                                 <div class="img5">
                                 	<span class="img5l"><img src="<?php echo $pre . $vv['thumb_src']; ?>" /></span>
                                    <span class="img5r"><img src="<?php echo $pre . $vv['img_src']; ?>" /></span>
                                 </div>
							<?php endforeach; ?>
							</div>
                         <?php endforeach; ?>
                        </div><br />
                        <div class="zuopins">
                        <?php for($i=1;$i<=$cases[0];$i++): 						
						if($i==1)
						{
							echo '<span class="cur">1</span>';
						}
						else
						{
							echo '<span>' . $i . '</span>';
						}                        	
						 endfor;?>
                        </div>
                   </div>
                   
            </div>
        </div>  
        
        

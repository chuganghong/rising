				   <script type="text/javascript">
					$(function(){
					$(".brand span").click(function(){
					$(this).next().show();
					});
					$(".brand").mouseleave(function(){
					$(".showdetail").hide();
					})
					})
					</script>
                   <div class="pageRcon">
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
                        </div>
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
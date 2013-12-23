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
        	<div class="advertise">
            	<div class="bigpic"><a href="#"><img src="<?php echo $pre; ?>public/images/about_03.jpg" /></a></div>
            </div>
            
            
            <div class="page">
            		<div class="pagenav">
                    	 <h3>日先作品</h3>
                         <span ><a href="#">合作品牌</a></span>
                         <span class="cur"><a href="#">经典案例</a></span>
                    </div>
                    
                   <div class="pageRcon">
                   		<div class="zuopinwrap">
                            <div class="zuopin zuopinm" style="z-index:2">
                                 <img src="<?php echo $pre; ?>public/images/zp_07.png" />
                            </div>
                            <div class="zuopin zuopinm">
                                 <img src="<?php echo $pre; ?>public/images/zp_07.png" />
                            </div>
                            <div class="zuopin zuopinm">
                                 <img src="<?php echo $pre; ?>public/images/zp_07.png" />
                            </div>
                        </div>
                        <div class="zuopins">
                        	<span class="cur">1</span>
                            <span>2</span>
                            <span>3</span>	
                        </div>
                        
                   </div>
                   
            </div>
        </div>    
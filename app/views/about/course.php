			<script type="text/javascript">
			$(function(){
			$(".prints").css({width:$(".printsub").length*303})
			})
			</script>
            
            <!--
			<div class="page subpage">
            	
            		<div class="pagenav">
                    	 <h3>关于我们&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
                         <span class="cur"><a href="#">日先简介</a></span>
                         <span><a href="#">日先足迹</a></span>
                         <span><a href="#">日先荣誉</a></span>
                         <span><a href="#">日先理念</a></span>
                    </div>
					-->
                    <div class="pageRcon">
                                <div class="toptxt">
                                    <h3>
                                        <?php echo $cat_desc; ?>
                                    </h3><br />
                                 </div>
                                 <div class="print">
                                 		<div class="contxt">
                                            <?php echo $intro_content; ?>
                                            
                                            <div class="times">
                                            	<img src="<?php echo $pre . $pic; ?>" class="timesimg" style="width:303px;height:294px;" />
                                                <div class="times_r">
                                                	<div class="printwrap">
                                                        <div class="prints">
														<?php foreach($other[1] as $k=>$v): ?>
                                                        	<div class="printsub">
                                                                <b><?php echo $v['title']; ?></b><br />
                                                                <?php echo $v['content']; ?>
                                                            </div>
														<?php endforeach; ?>                                                            
                                                        </div>
                                                     </div>
													 <span class="icopositon">
                                                     	 <i>1/<?php echo $other[0]; ?></i>  <a href="javascript:void(0)" class="imgprev"></a><a href="javascript:void(0)" class="imgnext"></a>
                                                     </span>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                 </div>
                    
                    </div>
            </div>
        </div> 
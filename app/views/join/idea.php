<script  type="text/javascript">
		$(function(){
		$('.direct').css({width:$(".subdirect").length*435})
		
		$(".next1").click(function(){
				var pos= $(".direct").position();
				console.log(pos.left)
				console.log($(".subdirect").length-1)
				if(pos.left > -($(".subdirect").length-1)*435 && !$(".direct").is(":animated")){
					$(".direct").animate({
							left:'-=435'
						})}else{
							return false
						}
				
			})
		$(".prev1").click(function(){
				var pos= $(".direct").position();
				console.log(pos.left)
				console.log($(".subdirect").length-1)
				if(pos.left < 0 && !$(".direct").is(":animated")){
					$(".direct").animate({
							left:'+=435'
						})}else{
							return false
						}
				
			})
		})
</script>
        	
            
            
           <!--<div class="page subpage">
            	
            		<div class="pagenav">
                    	 <h3>加入我们&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
                         <span class="cur"><a href="#">人才理念</a></span>
                         <span><a href="#">招聘职位</a></span>
                    </div>
					-->
                    <div class="pageRcon">
                    <div class="toptxt">
                    	<h3>
                        	<?php echo $cat_desc; ?>
						</h3><br />

                    </div>
                    <div class="mid_con">                        
                          
                          <div class="conlevel">
                          	  <div class="contxt">
                          		<h4>人才培养</h4>
                                <em><?php echo $content1[0]; ?></em>
								<?php echo $content1[2]['content']; ?>
								<div class="detailcontent">
                                	<div class="directwrap">
                                		<div class="direct">
                                            <?php foreach($content1 as $k=>$v):
											switch($k):
												case 0:
												case 1:
												case 2:
													continue 2;																								
											endswitch;
											?>
											<div class="subdirect">
											<?php echo $v['content']; ?>
                                            </div>
											<?php endforeach; ?>                                           
										</div>
                                    </div>
										<div class="changenext">
                                                 <b>1/<?php echo $content1[1]; ?></b> <span class="prev1"></span><span class="next1"></span>&nbsp;&nbsp;
                                        </div>
                                </div>

							   <br />
                               <em><?php echo $content2[0]; ?></em><br />
							   <?php echo $content2[1]['content']; ?>                               
                               <div class="detailcontent">
                               		<div class="dtitle">
									<?php
									$i = 1;
									foreach($content2 as $k=>$v):
									if($k==0||$k==1):
									continue;
									endif;
									if($i==1):
									echo '<span class="cur">' . $v['title'] . '</span>';
									else:
									echo '<span>' . $v['title'] . '</span>';
									endif;
									$i++;
									endforeach;
									?>
                                    </div>
									
									
									<?php
									$i = 1;
									$str = '';
									foreach($content2 as $k=>$v):
									if($k==0||$k==1):
									continue;
									endif;
									if($i==1):
									$str .= '<div class="dtxtcon" style="display:block">';									
									else:
									$str .= '<div class="dtxtcon">';
									endif;
									$i++;
									
									$str .= $v['content'];
									$str .= '</div>';
									endforeach;
									echo $str;
									?>  
								</div>
                          </div>
                          <br />
                          <br />
                          <br />
						  </div>
                          
                          
                          
                    </div>
                    <div class="right_con">
							<h3>&plus; 新闻会客室</h3>
					<?php foreach($news as $k=>$v): ?>					
                            <a href="<?php echo $v['action_name']; ?>" target="_blank"><img src="<?php echo $pre . $v['pic']; ?>" /></a>
                            <p><?php echo mb_substr($v['cat_desc'],0,360); ?></p>
                    <?php endforeach; ?>
					</div>
                  </div>
            </div>
        </div>         

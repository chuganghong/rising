    
            
            <div class="page subpage">
            	
            		<div class="pagenav">
					<?php
					$str = '';
					foreach($pagenav as $k=>$v)
					{						
						if($k==0)
						{
							$str .= '<h3>' . $v['cat_name'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rarr;</h3>';							
						}
						else if($k == 1)
						{
							continue;							
						}
						else
						{
							if($v['cat_id'] == $cur2)
							{								
								$str .='<span class="cur">';
							}
							else
							{
								$str .= '<span>';
							}
							$str .= '<a href="' . $v['action_name'] . '">' . $v['cat_name'] . '</a></span>';
						}						
					}
					echo $str;
                    ?>
                    </div>
					
                    <div class="pageRcon">
                    <div class="toptxt">
                    	<h3>
                        	<img src="<?php echo $pre; ?>public/images/view_03.jpg" />
						</h3><br />

                    </div>
                    <div class="mid_con"> 
                    	
                          
                          
                          <div class="conlevel">
                          	  <div class="contxt">
                          		<h4>店铺视角</h4>
                               <div class="shoplist">
							   <?php foreach($content as $k=>$v): ?>   
							   
									<div class="shoplists">
										<img src="<?php echo $pre . $v['g_pic']; ?>" />
										<div class="shoplist_txt">
											<p><a href="<?php echo $url_detail . $v['Case_id']; ?>"><?php echo mb_substr($v['title'],0,15); ?></a> <i><?php echo date('Y-m-d',$v['addtime']); ?></i></p>
											<p><?php echo mb_substr($v['content_en'],0,100); ?></p>
										</div>	
                                    </div>
								<?php endforeach; ?>                               
                                    
                                    <div class="pages">
									<?php echo $page;  ?>
                                    		
											<input type="hidden" value="<?php echo $which; ?>" id="which" />
                                            <span class="chosepage">到第<input type="text" class="text" id="gpage" value="<?php echo $cur_page2; ?>" />页</span>
                                            <input class="button" type="button" value="确定" id="goto">											
                                    </div>
                                    
                                    
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
        
       
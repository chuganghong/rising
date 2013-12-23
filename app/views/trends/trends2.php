
            
            <!--
            <div class="page subpage">
            	
            		<div class="pagenav">
                    	 <h3>动态与观点&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
                         <span><a href="#">店铺视角</a></span>
                         <span   class="cur"><a href="#">日先动态</a></span>
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
                          		<h4>日先动态</h4>
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
        
        

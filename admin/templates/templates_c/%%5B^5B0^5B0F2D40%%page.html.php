<?php /* Smarty version 2.6.14, created on 2013-09-03 17:56:44
         compiled from page.html */ ?>
    <div id="turn-page">
        总计 <span id="totalRecords"><?php echo $this->_tpl_vars['record_count']; ?>
</span>
        个记录分为 <span id="totalPages"><?php echo $this->_tpl_vars['page_count']; ?>
</span>
        页当前第 <span id="pageCurrent"><?php echo $this->_tpl_vars['filter']['page']; ?>
</span>
        页，每页 <input type='text' size='3' id='pageSize' value="<?php echo $this->_tpl_vars['filter']['page_size']; ?>
" onkeypress="return listTable.changePageSize(event)" />&nbsp;&nbsp;
        <span id="page-link">
          <?php echo '<a href="javascript:listTable.gotoPageFirst()">'; ?>
第一页</a>
          <?php echo '<a href="javascript:listTable.gotoPagePrev()">'; ?>
上一页</a>
          <?php echo '<a href="javascript:listTable.gotoPageNext()">'; ?>
下一页</a>
          <?php echo '<a href="javascript:listTable.gotoPageLast()">'; ?>
最末页</a>
          <select id="gotoPage" onchange="listTable.gotoPage(this.value)">
                        
                <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=$this->_tpl_vars['page_count']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
                <?php if ($this->_sections['loop']['iteration'] == $this->_tpl_vars['filter']['page']): ?>
                <option value="<?php echo $this->_sections['loop']['iteration']; ?>
" selected="true"><?php echo $this->_sections['loop']['iteration']; ?>
</option>
                <?php else: ?>
                <option value="<?php echo $this->_sections['loop']['iteration']; ?>
"><?php echo $this->_sections['loop']['iteration']; ?>
</option>
                <?php endif; ?>
            <?php endfor; endif; ?>
          </select>
        </span> 
      </div>
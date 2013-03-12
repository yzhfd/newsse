<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.4.4.min.js')); ?>
<script type="text/javascript">
    var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
    
    jQuery.noConflict();
jQuery(
    function()
    {
        var allsortLateCall = new lateCall(200,function(){
            jQuery('#div_allsort').show();
        });
        //商品分类
        jQuery('.allsort').hover(
            function(){
                allsortLateCall.start();
            },
            function(){
                allsortLateCall.stop();
                jQuery('#div_allsort').hide();
            }
            );
       jQuery('.sortlist li').each(
            function(i)
            {
               jQuery(this).hover(
                    function(){
                        jQuery(this).addClass('hover');
                        jQuery('.sublist:eq('+i+')').show();
                    },
                    function(){
                        jQuery(this).removeClass('hover');
                        jQuery('.sublist:eq('+i+')').hide();
                    }
                    );
            }
            );
            
    }) 
    
</script>


<div class="block clearfix header">
    <div class="f_l"><a href="index.php" name="top"><img src="themes/default/images/logo.gif" /></a></div>
    <div class="f_r">
        <ul>

            <?php if ($this->_var['navigator_list']['top']): ?>
            <li id="topNav" >
                <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
                <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a>
                <?php if (! ($this->_foreach['nav_top_list']['iteration'] == $this->_foreach['nav_top_list']['total'])): ?>
                |
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <div class="topNavR"></div>
            </li>
            <?php endif; ?>
        </ul>

        <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
        <font id="ECS_MEMBERZONE"> <?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></font>

    </div>
</div>
<div  class="blank"></div>
<div id="mainNav" class="clearfix">
    <ul>
        <li> <a href="index.php"<?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['lang']['home']; ?><span></span></a></li>
        <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
         <li>
            <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?> <?php if ($this->_var['nav']['active'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?><span></span></a>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>  
   
</div>



<div class="searchbar">
    <div class="allsort">
         <script type="text/javascript">
            
            <!--
            function checkSearchForm()
            {
                if(document.getElementById('keyword').value)
                {
                    return true;
                }
                else
                {
                    alert("<?php echo $this->_var['lang']['no_keywords']; ?>");
                    return false;
                }
            }
            -->
            
        </script>
        <a href="javascript:void(0);">全部商品分类</a>
        <ul id="div_allsort" class="sortlist" style="display: none;">
            <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
            <li class="">
                <h2>
                    <a href="<?php echo $this->_var['cat']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat']['name']); ?></a>
                </h2>
                <div class="sublist" style="display: none;">
                    <div class="items">
                        <strong>选择分类</strong>
                        <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
                        <dl class="category selected">
                            <dt>
                            <a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a>
                            </dt>
                            <dd>
                                <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?>
                                <a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a>
                                |
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </dd>
                        </dl>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                </div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <div class="searchbox">
        <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r"  style="_position:relative; top:5px;">
            <input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($this->_var['search_keywords']); ?>" class="B_input" style="height: 20px; line-height: 20px;margin-left: 8px;margin-top: 5px;width: 203px;"/>
            <input name="imageField"  type="submit" value="商品搜索" class="btn"  style="cursor:pointer;" />
        </form>
    </div>
    <div class="hotwords">
       <?php if ($this->_var['searchkeywords']): ?>
        <?php echo $this->_var['lang']['hot_search']; ?> ：
        <?php $_from = $this->_var['searchkeywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
        <a href="search.php?keywords=<?php echo urlencode($this->_var['val']); ?>"><?php echo $this->_var['val']; ?></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?>
    </div>
</div>
<div class="blank"></div>
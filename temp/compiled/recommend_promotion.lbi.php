<?php if ($this->_var['promotion_goods']): ?>
<div id="sales" class="f_l clearfix">
    <h1><div class="more"><a href="search.php?intro=promotion">更多特价...</a></div></h1>
       <div class="clearfix goodBox">
         <?php $_from = $this->_var['promotion_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_54104700_1359877940');$this->_foreach['promotion_foreach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promotion_foreach']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_54104700_1359877940']):
        $this->_foreach['promotion_foreach']['iteration']++;
?>
         <?php if (($this->_foreach['promotion_foreach']['iteration'] - 1) <= 3): ?>
           <div class="goodList">
           <a href="<?php echo $this->_var['goods_0_54104700_1359877940']['url']; ?>"><img src="<?php echo $this->_var['goods_0_54104700_1359877940']['thumb']; ?>" border="0" alt="<?php echo htmlspecialchars($this->_var['goods_0_54104700_1359877940']['name']); ?>"/></a><br />
					 <p><a href="<?php echo $this->_var['goods_0_54104700_1359877940']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_54104700_1359877940']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods_0_54104700_1359877940']['short_name']); ?></a></p>
           <?php echo $this->_var['lang']['promote_price']; ?><font class="f1"><?php echo $this->_var['goods_0_54104700_1359877940']['promote_price']; ?></font>
           </div>
         <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </div>
      </div>
<?php endif; ?>
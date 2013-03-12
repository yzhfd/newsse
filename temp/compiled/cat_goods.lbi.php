<div class="box">
 <div class="box_1">
  <h3><span><a href="<?php echo $this->_var['goods_cat']['url']; ?>" class="f6"><?php echo htmlspecialchars($this->_var['goods_cat']['name']); ?></a></span></h3>
    <div class="centerPadd">
    <div class="clearfix goodsBox" style="border:none;">
      <?php $_from = $this->_var['cat_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_60045300_1359877940');if (count($_from)):
    foreach ($_from AS $this->_var['goods_0_60045300_1359877940']):
?>
      <div class="goodsItem">
           <a href="<?php echo $this->_var['goods_0_60045300_1359877940']['url']; ?>"><img src="<?php echo $this->_var['goods_0_60045300_1359877940']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_60045300_1359877940']['name']); ?>" class="goodsimg" /></a><br />
           <p><a href="<?php echo $this->_var['goods_0_60045300_1359877940']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_60045300_1359877940']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods_0_60045300_1359877940']['short_name']); ?></a></p>
           <?php if ($this->_var['goods_0_60045300_1359877940']['promote_price'] != ""): ?>
          <font class="shop_s"><?php echo $this->_var['goods_0_60045300_1359877940']['promote_price']; ?></font>
          <?php else: ?>
          <font class="shop_s"><?php echo $this->_var['goods_0_60045300_1359877940']['shop_price']; ?></font>
          <?php endif; ?>
        </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <div class="more"><a href="<?php echo $this->_var['goods_cat']['url']; ?>">更多商品...</a></div>
    </div>
    </div>
 </div>
</div>
<div class="blank5"></div>

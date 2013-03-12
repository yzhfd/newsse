<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
    <body class="index">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="block clearfix">
  
  <div class="AreaL">
    
    <div class="box">
     <div class="box_1">
      <h3><span><?php echo $this->_var['lang']['shop_notice']; ?></span></h3>
      <div class="boxCenterList RelaArticle">
        <?php echo $this->_var['shop_notice']; ?>
      </div>
     </div>
    </div>
    <div class="blank5"></div>
    
    
     <div class="box">
     <div class="box_1">
      <div class="boxCenterList RelaArticle">
          商店在售经验值总数：<?php echo $this->_var['sum_exp']; ?><br/><a href="user.php?act=exp_value_buy" target="_blank">购买</a>
      </div>
     </div>
    </div>
     
    
  
<?php echo $this->fetch('library/cart.lbi'); ?>
<?php echo $this->fetch('library/category_tree.lbi'); ?>
<?php echo $this->fetch('library/top10.lbi'); ?>
<?php echo $this->fetch('library/promotion_info.lbi'); ?>
<?php echo $this->fetch('library/order_query.lbi'); ?>
<?php echo $this->fetch('library/invoice_query.lbi'); ?>
<?php echo $this->fetch('library/vote_list.lbi'); ?>
<?php echo $this->fetch('library/email_list.lbi'); ?>


  </div>
  
  
  <div class="AreaR">
   
    <div class="box clearfix">
     <div class="box_1 clearfix">
       <div class="f_l" id="focus">
       <?php echo $this->fetch('library/index_ad.lbi'); ?>
       </div>
       
       <div id="mallNews" class="f_r">
        <div class="NewsTit"></div>
        <div class="NewsList tc">
         

        <?php echo $this->fetch('library/new_articles.lbi'); ?>
        </div>
       </div>
       
     </div>
    </div>
    <div class="blank5"></div>
   
   
    <div class="clearfix">
      
      <?php echo $this->fetch('library/recommend_promotion.lbi'); ?>
      
      <div class="box f_r brandsIe6">
       <div class="box_1 clearfix" id="brands">
        <?php echo $this->fetch('library/brands.lbi'); ?>
       </div>
      </div>
    </div>
    <div class="blank5"></div>
   
<?php echo $this->fetch('library/recommend_best.lbi'); ?>
<?php echo $this->fetch('library/recommend_new.lbi'); ?>
<?php echo $this->fetch('library/recommend_hot.lbi'); ?>
<?php $this->assign('cat_goods',$this->_var['cat_goods_1']); ?><?php $this->assign('goods_cat',$this->_var['goods_cat_1']); ?><?php echo $this->fetch('library/cat_goods.lbi'); ?>
<?php echo $this->fetch('library/auction.lbi'); ?>
<?php echo $this->fetch('library/group_buy.lbi'); ?>


<div class="comment boxc m_10">
<div class="title2">
<h2>
<img width="155" height="36" alt="最新评论" src="themes/default/images/front/comment.gif">
</h2>
</div>
    <div class="cont clearfix">
        <?php $_from = $this->_var['my_comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comments');if (count($_from)):
    foreach ($_from AS $this->_var['comments']):
?>
        <dl class="no_bg">
            <dt>
                <a href="goods.php?id=<?php echo $this->_var['comments']['id_value']; ?>">
                    <img width="65" height="65" src="<?php echo $this->_var['comments']['thumb']; ?>">
                </a>
            </dt>
            <dd>
                <a href="goods.php?id=<?php echo $this->_var['comments']['id_value']; ?>"><?php echo sub_str($this->_var['comments']['content'],15); ?></a>
            </dd>
            <dd>
                <span class="grade">
                    <i style="width:<?php echo $this->_var['comments']['comment_rank']; ?>px"></i>
                </span>
            </dd>
            <dd class="com_c"><?php echo sub_str($this->_var['comments']['content'],15); ?></dd>
        </dl>
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
</div>
<div class="box">
 <div class="box_1">
     <h3><span><a class="f6" href="/local.php" target="_blank">同城商品</a></span></h3>
    <div class="centerPadd">
    <div class="clearfix goodsBox" style="border:none;">
      <?php $_from = $this->_var['local_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
      <div class="goodsItem">
           <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="goodsimg" /></a><br />
           <p><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo htmlspecialchars($this->_var['goods']['short_name']); ?></a></p>
           <?php if ($this->_var['goods']['promote_price'] != ""): ?>
          <font class="shop_s"><?php echo $this->_var['goods']['promote_price']; ?></font>
          <?php else: ?>
          <font class="shop_s"><?php echo $this->_var['goods']['shop_price']; ?></font>
          <?php endif; ?>
        </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <div class="more"><a href="local.php">更多商品...</a></div>
    </div>
    </div>
 </div>
</div>
<div class="blank5"></div>
 
  </div>
  
</div>
<div class="blank5"></div>

<div class="block">
  <div class="box">
   <div class="helpTitBg clearfix">
    <?php echo $this->fetch('library/help.lbi'); ?>
   </div>
  </div>
</div>
<div class="blank"></div>


<?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
<div id="bottomNav" class="box">
 <div class="box_1">
  <div class="links clearfix">
    <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
    <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['txt_links']): ?>
    <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
    [<a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>]
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endif; ?>
  </div>
 </div>
</div>
<?php endif; ?>

<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>

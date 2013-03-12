<?php

/**
 * ECSHOP 同城商品
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: category.php 17217 2011-01-19 06:29:08Z liubo $
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2) {
    $smarty->caching = true;
}

/* ------------------------------------------------------ */
//-- INPUT
/* ------------------------------------------------------ */


/* 初始化分页信息 */
$page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
$size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
$pid = isset($_REQUEST['pid']) && intval($_REQUEST['pid']) > 0 ? intval($_REQUEST['pid']) : 0; //省份ID
$cid = isset($_REQUEST['cid']) && intval($_REQUEST['cid']) > 0 ? intval($_REQUEST['cid']) : 0;
$did = isset($_REQUEST['did']) && intval($_REQUEST['did']) > 0 ? intval($_REQUEST['did']) : 0;



/* 排序、显示方式以及类型 */
$default_display_type = $_CFG['show_order_type'] == '0' ? 'list' : ($_CFG['show_order_type'] == '1' ? 'grid' : 'text');
$default_sort_order_method = $_CFG['sort_order_method'] == '0' ? 'DESC' : 'ASC';
$default_sort_order_type = $_CFG['sort_order_type'] == '0' ? 'goods_id' : ($_CFG['sort_order_type'] == '1' ? 'shop_price' : 'last_update');

$sort = (isset($_REQUEST['sort']) && in_array(trim(strtolower($_REQUEST['sort'])), array('goods_id', 'shop_price', 'last_update'))) ? trim($_REQUEST['sort']) : $default_sort_order_type;
$order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array('ASC', 'DESC'))) ? trim($_REQUEST['order']) : $default_sort_order_method;
$display = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array('list', 'grid', 'text'))) ? trim($_REQUEST['display']) : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
$display = in_array($display, array('list', 'grid', 'text')) ? $display : 'text';
setcookie('ECS[display]', $display, gmtime() + 86400 * 7);
/* ------------------------------------------------------ */
//-- PROCESSOR
/* ------------------------------------------------------ */

/* 页面的缓存ID */
$cache_id = sprintf('%X', crc32($display . '-' . $sort . '-' . $order . '-' . $page . '-' . $size . '-' . $_SESSION['user_rank'] . '-' .
                $_CFG['lang'] . '-' . $pid . '-' . $cid . '-' . $did));

if (!$smarty->is_cached('local.dwt', $cache_id)) {
    /* 如果页面没有被缓存则重新获取页面的内容 */

    if ($did > 0) {//说明是选择地区
        $sql = "SELECT distinct goods_id FROM " . $ecs->table('goods_region') . " WHERE region_id=" . $did;
    } elseif ($cid > 0) {
        $all = get_regions(3, $cid);
        $rids = array();
        foreach ($all as $val) {
            $rids[] = $val['region_id'];
        }
        $rids[] = $cid;
        $sql = "SELECT distinct goods_id FROM " . $ecs->table('goods_region') . " WHERE " . db_create_in($rids, "region_id");
    } elseif ($pid > 0) {
        $all = get_regions(2, $pid);
        $cids = array();
        foreach ($all as $val) {
            $region_id = $val['region_id'];
            $ddall = get_regions(3, $region_id);
            foreach ($ddall as $dd) {
                $cids[] = $dd['region_id'];
            }
            $cids[] = $region_id;
        }
        $cids[] = $pid;
        $sql = "SELECT distinct goods_id FROM " . $ecs->table('goods_region') . " WHERE " . db_create_in($cids, "region_id");
    } else {
        $sql = "SELECT distinct goods_id FROM " . $ecs->table('goods_region') . " WHERE 1";
    }
    $regions = $db->getAll($sql);
    $gids = array();
    foreach ($regions as $region) {
        $gids[] = $region['goods_id'];
    }

    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title', $position['title']);    // 页面标题
    $smarty->assign('ur_here', $position['ur_here']);  // 当前位置

    $smarty->assign('categories', get_categories_tree()); // 分类树
    $smarty->assign('helps', get_shop_help());              // 网店帮助
    $smarty->assign('top_goods', get_top10());                  // 销售排行
    $smarty->assign('show_marketprice', $_CFG['show_marketprice']);
    $smarty->assign('pid', $pid);
    $smarty->assign('cid', $cid);
    $smarty->assign('did', $did);
    $smarty->assign('feed_url', ($_CFG['rewrite'] == 1) ? "feed-c$cat_id.xml" : 'feed.php?cat=' . $cat_id); // RSS URL

    $smarty->assign('data_dir', DATA_DIR);
    $smarty->assign('promotion_info', get_promotion_info());

    /* 调查 */
    $vote = get_vote();
    if (!empty($vote)) {
        $smarty->assign('vote_id', $vote['id']);
        $smarty->assign('vote', $vote['content']);
    }


    $count = count($gids);
    $max_page = ($count > 0) ? ceil($count / $size) : 1;
    if ($page > $max_page) {
        $page = $max_page;
    }
    $goodslist = local_get_goods($gids, $size, $page, $sort, $order);
    if ($display == 'grid') {
        if (count($goodslist) % 2 != 0) {
            $goodslist[] = array();
        }
    }
    $provinces = get_regions(1, 1);
    foreach ($provinces as $key => $val) {
        $provinces[$key]['url'] = build_uri('local', array('pid' => $val['region_id'], 'ccid' => 0, 'did' => 0));
    }
    $smarty->assign('provinces', $provinces);


    if ($pid > 0) {
        $citys = get_regions(2, $pid);
        foreach ($citys as $key => $val) {
            $citys[$key]['url'] = build_uri('local', array('pid' => $pid, 'ccid' => $val['region_id'], 'did' => 0));
           
        }
         $smarty->assign('citys', $citys);
    }
    if ($cid) {
        $diss = get_regions(3, $cid);
        foreach ($diss as $key => $val) {
            $diss[$key]['url'] = build_uri('local', array('pid' => $pid, 'ccid' => $cid, 'did' => $val['region_id']));
        }
        $smarty->assign('diss', $diss);
    }
    $smarty->assign('goods_list', $goodslist);
    $smarty->assign('script_name', 'local');

    assign_pager('local', 0, $count, $size, $sort, $order, $page, '', $pid, $cid, $did, $display, $filter_attr_str); // 分页
    assign_dynamic('category'); // 动态内容
}

$smarty->display('local.dwt', $cache_id);

/**
 * 获得分类下的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */
function local_get_goods($gids, $size, $page, $sort, $order) {
    $display = $GLOBALS['display'];
    $where = "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND " .
            "g.is_delete = 0 AND " . db_create_in($gids, "g.goods_id");

    /* 获得商品列表 */
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ' .
            "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, g.goods_type, " .
            'g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . ' AS mp ' .
            "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' " .
            "WHERE $where $ext ORDER BY $sort $order";
    $res = $GLOBALS['db']->selectLimit($sql, $size, ($page - 1) * $size);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res)) {
        if ($row['promote_price'] > 0) {
            $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
        } else {
            $promote_price = 0;
        }

        /* 处理商品水印图片 */
        $watermark_img = '';

        if ($promote_price != 0) {
            $watermark_img = "watermark_promote_small";
        } elseif ($row['is_new'] != 0) {
            $watermark_img = "watermark_new_small";
        } elseif ($row['is_best'] != 0) {
            $watermark_img = "watermark_best_small";
        } elseif ($row['is_hot'] != 0) {
            $watermark_img = 'watermark_hot_small';
        }

        if ($watermark_img != '') {
            $arr[$row['goods_id']]['watermark_img'] = $watermark_img;
        }

        $arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
        if ($display == 'grid') {
            $arr[$row['goods_id']]['goods_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        } else {
            $arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
        }
        $arr[$row['goods_id']]['name'] = $row['goods_name'];
        $arr[$row['goods_id']]['goods_brief'] = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_style_name'] = add_style($row['goods_name'], $row['goods_name_style']);
        $arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
        $arr[$row['goods_id']]['type'] = $row['goods_type'];
        $arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
        $arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url'] = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
    }

    return $arr;
}

?>

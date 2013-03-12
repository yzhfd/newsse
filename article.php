<?php

/**
 * ECSHOP ��������
 * ============================================================================
 * * ��Ȩ���� 2005-2012 �Ϻ���������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.ecshop.com��
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
 * $Author: liubo $
 * $Id: article.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

$_REQUEST['id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$article_id     = $_REQUEST['id'];
if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] < 0)
{
    $article_id = $db->getOne("SELECT article_id FROM " . $ecs->table('article') . " WHERE cat_id = '".intval($_REQUEST['cat_id'])."' ");
}

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

$cache_id = sprintf('%X', crc32($_REQUEST['id'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('article.dwt', $cache_id))
{
    /* �������� */
    $article = get_article_info($article_id);

    if (empty($article))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    if (!empty($article['link']) && $article['link'] != 'http://' && $article['link'] != 'https://')
    {
        ecs_header("location:$article[link]\n");
        exit;
    }

    $smarty->assign('article_categories',   article_categories_tree($article_id)); //���·�����
    $smarty->assign('categories',       get_categories_tree());  // ������
    $smarty->assign('helps',            get_shop_help()); // �������
    $smarty->assign('top_goods',        get_top10());    // ��������
    $smarty->assign('best_goods',       get_recommend_goods('best'));       // �Ƽ���Ʒ
    $smarty->assign('new_goods',        get_recommend_goods('new'));        // ������Ʒ
    $smarty->assign('hot_goods',        get_recommend_goods('hot'));        // �ȵ�����
    $smarty->assign('promotion_goods',  get_promote_goods());    // �ؼ���Ʒ
    $smarty->assign('related_goods',    article_related_goods($_REQUEST['id']));  // �ؼ���Ʒ
    $smarty->assign('id',               $article_id);
    $smarty->assign('username',         $_SESSION['user_name']);
    $smarty->assign('email',            $_SESSION['email']);
    $smarty->assign('type',            '1');
    $smarty->assign('promotion_info', get_promotion_info());

    /* ��֤��������� */
    if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
    {
        $smarty->assign('enabled_captcha', 1);
        $smarty->assign('rand',            mt_rand());
    }

    $smarty->assign('article',      $article);
    $smarty->assign('keywords',     htmlspecialchars($article['keywords']));
    $smarty->assign('description', htmlspecialchars($article['description']));

    $catlist = array();
    foreach(get_article_parent_cats($article['cat_id']) as $k=>$v)
    {
        $catlist[] = $v['cat_id'];
    }

    assign_template('a', $catlist);

    $position = assign_ur_here($article['cat_id'], $article['title']);
    $smarty->assign('page_title',   $position['title']);    // ҳ�����
    $smarty->assign('ur_here',      $position['ur_here']);  // ��ǰλ��
    $smarty->assign('comment_type', 1);

    /* �����Ʒ */
    $sql = "SELECT a.goods_id, g.goods_name " .
            "FROM " . $ecs->table('goods_article') . " AS a, " . $ecs->table('goods') . " AS g " .
            "WHERE a.goods_id = g.goods_id " .
            "AND a.article_id = '$_REQUEST[id]' ";
    $smarty->assign('goods_list', $db->getAll($sql));

    /* ��һƪ��һƪ���� */
    $next_article = $db->getRow("SELECT article_id, title FROM " .$ecs->table('article'). " WHERE article_id > $article_id AND cat_id=$article[cat_id] AND is_open=1 LIMIT 1");
    if (!empty($next_article))
    {
        $next_article['url'] = build_uri('article', array('aid'=>$next_article['article_id']), $next_article['title']);
        $smarty->assign('next_article', $next_article);
    }

    $prev_aid = $db->getOne("SELECT max(article_id) FROM " . $ecs->table('article') . " WHERE article_id < $article_id AND cat_id=$article[cat_id] AND is_open=1");
    if (!empty($prev_aid))
    {
        $prev_article = $db->getRow("SELECT article_id, title FROM " .$ecs->table('article'). " WHERE article_id = $prev_aid");
        $prev_article['url'] = build_uri('article', array('aid'=>$prev_article['article_id']), $prev_article['title']);
        $smarty->assign('prev_article', $prev_article);
    }

    assign_dynamic('article');
}
if(isset($article) && $article['cat_id'] > 2)
{
    $smarty->display('article.dwt', $cache_id);
}
else
{
    $smarty->display('article_pro.dwt', $cache_id);
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * ���ָ�������µ���ϸ��Ϣ
 *
 * @access  private
 * @param   integer     $article_id
 * @return  array
 */
function get_article_info($article_id)
{
    /* ������µ���Ϣ */
    $sql = "SELECT a.*, IFNULL(AVG(r.comment_rank), 0) AS comment_rank ".
            "FROM " .$GLOBALS['ecs']->table('article'). " AS a ".
            "LEFT JOIN " .$GLOBALS['ecs']->table('comment'). " AS r ON r.id_value = a.article_id AND comment_type = 1 ".
            "WHERE a.is_open = 1 AND a.article_id = '$article_id' GROUP BY a.article_id";
    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        $row['comment_rank'] = ceil($row['comment_rank']);                              // �û����ۼ���ȡ��
        $row['add_time']     = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']); // �������ʱ����ʾ

        /* ������Ϣ���Ϊ�գ�������վ�����滻 */
        if (empty($row['author']) || $row['author'] == '_SHOPHELP')
        {
            $row['author'] = $GLOBALS['_CFG']['shop_name'];
        }
    }

    return $row;
}

/**
 * ������¹�������Ʒ
 *
 * @access  public
 * @param   integer $id
 * @return  array
 */
function article_related_goods($id)
{
    $sql = 'SELECT g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                'g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date ' .
            'FROM ' . $GLOBALS['ecs']->table('goods_article') . ' ga ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = ga.goods_id ' .
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ".
            "WHERE ga.article_id = '$id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0";
    $res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        $arr[$row['goods_id']]['goods_name']    = $row['goods_name'];
        $arr[$row['goods_id']]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
            sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['market_price']  = price_format($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = price_format($row['shop_price']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);

        if ($row['promote_price'] > 0)
        {
            $arr[$row['goods_id']]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            $arr[$row['goods_id']]['formated_promote_price'] = price_format($arr[$row['goods_id']]['promote_price']);
        }
        else
        {
            $arr[$row['goods_id']]['promote_price'] = 0;
        }
    }

    return $arr;
}

?>
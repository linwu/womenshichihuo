<?php 
return array (
  'URL_MODEL' => 2,
  'URL_HTML_SUFFIX' => '.html',
  'URL_PATHINFO_DEPR' => '-',
  'URL_ROUTER_ON' => true,
  'URL_ROUTE_RULES' => 
  array (
	'/^go-(\d+).html$/' => 'index/go?id=:1',   
    '/^detail-(\d+).html$/' => 'post/index?id=:1',    
    '/^baoliao.html$/' => 'post/submit',
    '/^cate-(\d+).html$/' => 'post_cate/index?id=:1',
    '/^a-(\d+).html$/' => 'article/index?id=:1',
    '/^mall.html$/' => 'mall/index',
    '/^m-(\d+).html$/' => 'mall/info?id=:1',
    '/^login.html$/' => 'user/login',
    '/^register.html$/' => 'user/register',
    '/^faq.html$/' => 'help/faq?cate_id=19',
    '/^fanli.html$/' => 'help/faq?cate_id=20',
    '/^flink.html$/' => 'help/flink',
    '/^about.html$/' => 'help/page?id=2',
    '/^contact.html$/' => 'help/page?id=3',
    '/^partner.html$/' => 'help/page?id=4',
    '/^weixin.html$/' => 'help/page?id=12',
    '/^friends.html$/' => 'help/page?id=23',
    '/^(\w+).html$/' => 'post/index?post_key=:1',	
  ),
);
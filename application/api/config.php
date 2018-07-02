<?php
//配置文件
return[
	// 配置根目录
	define('SITE_URL', 'http://127.0.0.1/xs'),

	// phpssouid 相关参数配置
	'PHPSSO_API_URL'=>'http://mlaw.lvshiwangzhan.com/phpsso_server',
	'PHPSSO_AUTH_KEY'=>'Sod99Lz1vBx17KgZHfOnkWPTlh9PomsE',
	'PHPSSO_APPID'=>'1',
	// 关闭强制路由
	'url_route_must'         => false,
	// 视图输出字符串内容替换
    'view_replace_str'       => [
        '__STA__'=>SITE_URL.'/public/static',
        '__IMG__'=>SITE_URL.'/public/images'
    ],

    'Linkage_area_keyid' => 3360,
    'Linkage_classification_keyid' => 6650,
    'Linkage_accountMoney_keyid' => 6766,
];
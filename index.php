<?php

include_once 'config.php';

$list = scandir('data');
$data = array();
foreach($list as $name){
    if (($name!='.')&&($name!='..')){
        $data[$name] = json_decode(file_get_contents('data/'.$name), true);
    }
}

foreach($data as $k => $v){
    if ($v['timestamp'] + REFRESH_INTERVAL < time()){
        unset($data[$k]['timestamp']);
        foreach ($data[$k] as $k2 => $v2){
            $data[$k][$k2]['status'] = 'timeout';
        }
    }else{
        unset($data[$k]['timestamp']);
    }
}

$color = array();
$color['online'] = '#66EE00';
$color['offline'] = 'red';
$color['timeout'] = 'grey';
$color['error'] = 'blue';

$desc = array();
$desc['online'] = '服务正常';
$desc['offline'] = '服务异常';
$desc['timeout'] = 'Agent离线';
$desc['error'] = 'Agent错误';
?>

<html>
<head>
<title><?=SITE_NAME?></title>
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/mdui@0.4.3/dist/css/mdui.min.css">
<script src="https://cdn.jsdelivr.net/npm/mdui@0.4.3/dist/js/mdui.min.js"></script>
</head>
<body class="mdui-theme-primary-blue mdui-theme-accent-light-blue mdui-typo">

<center><h1 style="font-size: 1.9em;letter-spacing: 0.22em;margin-top: 25px;"><?=SITE_NAME?></h1></center>

<div style="margin-top: 10px;" class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-xs-12 mdui-col-offset-sm-2 mdui-col-sm-8">
            <div class="mdui-container">
                <div class="mdui-row">
                <?php foreach($data as $v0): ?>
                <?php foreach($v0 as $v): ?>
                    <div style="padding-top: 8px; padding-bottom: 8px;" class="mdui-col-xs-12 mdui-col-sm-6 mdui-col-md-4">
                        <div class="mdui-card">
                            <div class="mdui-card-header">
                            <div style="background-color: <?=$color[$v['status']]?>;" class="mdui-card-header-avatar"></div>
                            <div class="mdui-card-header-title"><?=$v['name']?></div>
                            <div class="mdui-card-header-subtitle"><?=$desc[$v['status']]?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mdui-typo" style="margin-top: 20px"><center><span>Powered by <a target="_blank" href="https://github.com/Netrvin/SimpleStatus">SimpleStatus</a>.</span></center></div>
</div>

</body>
</html>

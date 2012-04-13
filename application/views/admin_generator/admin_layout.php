<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?="<?=\$site_title;?>";?></title>
<meta name="description" content="<?="<?=\$site_description;?>";?>" />
<meta name="keywords" content="<?="<?=\$site_keywords;?>";?>" />
<?="<?=\$styles;?>";?>
<!-- JS -->
<?="<?=\$scripts_header;?>";?>
</head>
<body>
<div id="outer">
	<div id="header">
		<h1><a href="">CodeIgniter Admin Generator</a></h1>
	</div>
	<div id="menu">
		<ul>
<?php foreach ($model_list as $model): ?>
            <li><a href="<?="<?=site_url(\"admin/{$model}\");?>";?>"><?=ucfirst($model);?></a></li>
<?php endforeach; ?>
		</ul>
	</div>
    <div id="submenu">
        <a href="">haha</a>
    </div>

	<div id="content">
        <?="<?=\$content;?>";?>
    </div>
    <div id="footer">
	</div>
    <?="<?=\$scripts_footer;?>";?>
</body>

<?php

require __DIR__."/vendor/autoload.php";

use League\CLImate\CLImate;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;
//use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
$console = new CLImate();

$loader = new Twig_Loader_Filesystem(__DIR__.'/_templates');
$twig = new Twig_Environment($loader);

$mark = new ParsedownExtra();

$fs = new Filesystem(new Adapter(__DIR__."/_data"));
$data = [];
$ymls = $fs->listContents();
foreach ($ymls as $yml) {
    $data[$yml['filename']] = Yaml::parse($fs->read($yml['path']));
}

/**************************************************************
 First level pages
 *************************************************************/
$fs = new Filesystem(new Adapter(__DIR__."/_pages"));
$wrt = new Filesystem(new Adapter(__DIR__));
$pages = $fs->listContents("./", true);
foreach ($pages as $page) {
    if ($page['type'] !== 'file' || strtolower($page['extension']) !== 'md') {
        continue;
    }

    $html = $page['dirname']."/".$page['filename']."/index.html";
    $content = $fs->read($page['path']);
    $txt = $mark->text($content);
    $txt = $twig->render('page.twig', ['content'=> $txt, 'active' => 'introduction', 'data' => $data]);
    $console->out("<light_green>Building</light_green> <bold><light_cyan>{$html}<light_cyan></bold>");

    if ($page['dirname'] === "" && $page['filename'] === "index") {
        $wrt->put('index.html', $txt);
    } else {
        $wrt->put($html, $txt);
    }
}

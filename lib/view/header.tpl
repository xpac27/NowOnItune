<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <title>#{PAGE_TITLE}</title>

    <script language="javascript" type="text/javascript">var ROOT_PATH = '#{ROOT_PATH}';</script>

    <!-- section prod_environement -->
    <script language="javascript" type="text/javascript" src="#{ROOT_PATH}js/_prod/lib.js?#{VERSION}"></script>
    <script language="javascript" type="text/javascript" src="#{ROOT_PATH}js/_prod/base.js?#{VERSION}"></script>
    <!-- END prod_environement -->

    <!-- LOOP dev_script_list -->
    <script language="javascript" type="text/javascript" src="#{ROOT_PATH}#{dev_script_list.file}?#{VERSION}"></script>
    <!-- END dev_script_list -->

    <link rel="stylesheet" type="text/css" href="#{ROOT_PATH}css/stylesheets/main.css?#{VERSION}">
</head>
<body>

    <div class="main_content">


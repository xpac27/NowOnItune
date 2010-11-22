<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <title>#{PAGE_TITLE}</title>

    <meta name="description" content="#{PAGE_DESCRIPTION}" />

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link rel="icon" type="image/x-icon" href="#{ROOT_PATH}favicon.ico" />
    <link rel="shortcut icon" type="image/x-icon" href="#{ROOT_PATH}favicon.ico" />

    <script language="javascript" type="text/javascript">var ROOT_PATH = '#{ROOT_PATH}';</script>

    <!-- section prod_environement -->
    <script language="javascript" type="text/javascript" src="#{ROOT_PATH}js/_prod/lib.js?#{VERSION}"></script>
    <script language="javascript" type="text/javascript" src="#{ROOT_PATH}js/_prod/base.js?#{VERSION}"></script>
    <!-- END prod_environement -->

    <!-- LOOP dev_script_list -->
    <script language="javascript" type="text/javascript" src="#{ROOT_PATH}#{dev_script_list.file}?#{VERSION}"></script>
    <!-- END dev_script_list -->

    <link rel="stylesheet" type="text/css" href="#{ROOT_PATH}css/stylesheets/main.css?#{VERSION}">
    <script type="text/javascript">
        Cufon.replace('.cufon_normal', {'fontWeight' : 'normal'});
        Cufon.replace('.cufon_bold', {'fontWeight' : 'bold'});
    </script>
</head>
<body>

    <div class="main_content">


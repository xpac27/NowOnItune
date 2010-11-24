
    <div class="page block" id="band">

        <!-- SECTION online -->
        <div id="band_mask"></div>

        <h1 class="cufon_bold"><span id="band_name">#{band_name}.</span> <span id="band_now">Now on iTunes.</span></h1>

        <div id="band_cover">
            <a href="#{band_homepage}"><img src="#{MEDIA_PATH}band/725x0/#{band_id}.jpg"/></a>
        </div>

        <div class="permalink"><strong>permalink:</strong> <a href="#{band_url}">#{band_url}</a></div>

        <div class="share">
            <div class="twitter">
                <a href="http://twitter.com/share" class="twitter-share-button" data-text="#{band_name} Now On iTunes :" data-count="horizontal" data-via="NowOniTunes">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </div>
            <div class="facebook">
                <iframe src="http://www.facebook.com/plugins/like.php?href=#{band_url_encoded}&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
            </div>
        </div>
        <!-- END online -->

        <!-- SECTION offline -->
        <h1 class="cufon_bold">Oops.</h1>
        <h2 class="cufon_normal">This page has been removed due to a breach of the Terms of Use.</h2>
        <!-- END offline -->

    </div>

    <!-- SECTION online -->
    <script type="text/javascript">startBandAnimation();</script>
    <!-- END online -->


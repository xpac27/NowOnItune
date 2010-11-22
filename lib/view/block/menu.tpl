
        <div id="menu">
            <ul class="menu">
                <li class="home">
                    <a href="#{ROOT_PATH}">NowOnItune</a>
                </li>
                <li class="latest">
                    <a href="#{ROOT_PATH}latest">Latest</a>
                </li>
                <li class="top">
                    <a href="#{ROOT_PATH}top">Top</a>
                </li>
                <li class="random">
                    <a href="#{ROOT_PATH}random">Random</a>
                </li>
                <li class="create">
                    <a href="#{ROOT_PATH}">Create</a>
                </li>
                <li class="share">
                    <div class="twitter">
                        <a href="http://twitter.com/home?status=#{twitter_status}" target="_blank" title="share on Twitter !"><img src="#{ROOT_PATH}media/layout/button_twitter.png"></a>
                    </div>
                    <div class="facebook">
                        <a href="http://www.facebook.com/sharer.php?u=#{ROOT_PATH}&t=#{facebook_status}" target="_blank" title="share on Facebook !"><img src="#{ROOT_PATH}media/layout/button_facebook.png"></a>
                    </div>
                </li>
            </ul>
        </div>

        <div id="messages">
            <!-- SECTION feedback -->
            <p class="feedback">#{feedback}</p>
            <!-- END feedback -->

            <!-- SECTION warning -->
            <p class="warning">#{warning}</p>
            <!-- END warning -->
        </div>



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
                <li class="official">
                    <a href="#{ROOT_PATH}official">Official Users</a>
                </li>
                <li class="create">
                    <a href="#{ROOT_PATH}create">Generator</a>
                </li>
                <li class="search">
                    <form action="#{ROOT_PATH}" method="post">
                        <input name="q" value="#{search_query}" type="text" />
                    </form>
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


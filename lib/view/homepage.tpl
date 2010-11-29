
    <div class="page block" id="homepage">

        <h1 class="cufon_bold">Generator. Now on iTunes.</h1>
        <h2 class="cufon_normal">Today is just another day. That your fans will never forget.</h2>

        <form method="post" action="#{ROOT_PATH}remote/submit" enctype="multipart/form-data">

            <div class="col_left">
                <div class="line">
                    <label>
                        <span>Band</span>
                        <input type="text" value="#{band_name}" name="band_name" onfocus="javascript:cleanInput(this)" />
                    </label>
                </div>

                <div class="line">
                    <label>
                        <span>Picture</span>
                        <input type="file" name="band_cover" onfocus="javascript:cleanInput(this)" />
                    </label>
                    <p class="notice">JPG, PNG or GIF, 450KB - recommended: 725x855</p>
                </div>

                <div class="line">
                    <label>
                        <span>Website</span>
                        <input type="text" value="#{band_homepage}" name="band_homepage" onfocus="javascript:cleanInput(this)" />
                    </label>
                    <p class="notice">iTunes account URL recommended</p>
                </div>

                <div class="line">
                    <label>
                        <span class="cufon_normal">Email</span>
                        <input type="text" value="#{band_email}" name="band_email" onfocus="javascript:cleanInput(this)" />
                    </label>
                    <p class="notice_2">Your address will never be sold to anyone.</p>
                </div>
            </div>

            <div class="col_right">
                <div class="preview">
                    <img src="#{ROOT_PATH}media/layout/beatles.jpg" />
                </div>
                <div class="terms">
                    <input type="checkbox" value="1" name="terms" />I certify that my submission does not violate the <a href="#{ROOT_PATH}terms">terms of use</a>.
                </div>

                <div>
                    <label><input type="submit" value="Submit" name="submit" /></label>
                </div>
            </div>

            <div class="clear"></div>

        </form>

    </div>


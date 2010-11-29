
    <div class="page block" id="homepage">

        <h1 class="cufon_bold">Now on iTunes.</h1>
        <h2 class="cufon_normal">Today is just another day.</h2>
        <h2 class="cufon_normal">That your fans will never forget.</h2>

        <form method="post" action="#{ROOT_PATH}remote/submit" enctype="multipart/form-data">
            <div>
                <label><span class="cufon_normal">Band</span><input type="text" value="#{band_name}" name="band_name" /></label>
            </div>

            <div>
                <label><span class="cufon_normal">Picture</span><input type="file" name="band_cover" /></label>
                <p class="notice_1">JPG, PNG or GIF, 450KB - recommended: 725x855</p>
            </div>

            <div>
                <label><span class="cufon_normal">Website</span><input type="text" value="#{band_homepage}" name="band_homepage" /></label>
                <p class="notice_2">iTunes account URL recommended</p>
            </div>

            <div class="terms">
                <input type="checkbox" value="1" name="terms" />I certify that my submission does not violate the <a href="#{ROOT_PATH}terms">terms of use</a>.
            </div>

            <div class="captcha">
                <span>Are you human ? <img width="65" height="25" src="#{ROOT_PATH}remote/captcha" /></span> <input class="captcha" type="text" value="" name="captcha" />
            </div>

            <div>
                <label><input type="submit" value="Submit" name="submit" /></label>
            </div>
        </form>

    </div>


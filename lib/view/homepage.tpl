
    <div class="page" id="homepage">

        <!-- SECTION form_error -->
        <p class="error">You must complet the "brand's name" and the "brand's cover" field !</p>
        <!-- END form_error -->

        <form method="post" action="#{ROOT_PATH}remote/submit" enctype="multipart/form-data">
            <div>
                <label><span>Your band's name:</span><input type="text" value="" name="band_name" /></label>
            </div>

            <div>
                <label><span>Band's cover (JPG, PNG or GIF, 450KB 1680x1680px max):</span><input type="file" name="band_cover" /></label>
            </div>

            <div>
                <label><span>Band's homepage:</span><input type="text" value="" name="band_homepage" /></label>
            </div>

            <div>
                <label><input type="submit" value="Go !" name="submit" /></label>
            </div>
        </form>

    </div>


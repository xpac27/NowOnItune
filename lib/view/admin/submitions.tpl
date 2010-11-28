
    <div class="page" id="admin_submitions">

        <div class="block">
            <h1 class="cufon_bold">Latest submitions.</h1>
            <h2 class="cufon_normal">#{bands_total_online} online bands (#{bands_total_public} publics, #{bands_total_officials} officials) of #{bands_total} total.</h2>
            <div class="filters">
                Display only:
                    <label><input type="checkbox" value="1" name="online" #{filter_online_checked} onchange="javascript:Admin.band_changeFilters()" /> online</label>,
                    <label><input type="checkbox" value="1" name="public" #{filter_public_checked} onchange="javascript:Admin.band_changeFilters()" /> public</label>,
                    <label><input type="checkbox" value="1" name="official" #{filter_official_checked} onchange="javascript:Admin.band_changeFilters()" /> official</label> bands.
            </div>
        </div>

        <ul class="bands_detailed">
            <!-- LOOP bands -->
            <li class="band">
                <ul class="status">
                    <li><label><input type="checkbox" value="1" #{bands.online_checked} onchange="javascript:Admin.band_changeStatus(this, #{bands.id})" />online</label></li>
                    <li><label><input type="checkbox" value="1" #{bands.public_checked} onchange="javascript:Admin.band_changePublicStatus(this, #{bands.id})" />public</label></li>
                    <li><label><input type="checkbox" value="1" #{bands.official_checked} onchange="javascript:Admin.band_changeOfficialStatus(this, #{bands.id})" />official</label></li>
                </ul>
                <div class="preview">
                    <img width="120" height="120" src="#{MEDIA_PATH}band/120x120/#{bands.id}.jpg">
                </div>
                <div class="name"><a href="#{bands.url}">#{bands.name}</a></div>
                <ul class="info">
                    <li><span>id:</span>  #{bands.id}</li>
                    <li><span>homepage:</span>  <a href="#{bands.homepage}">#{bands.homepage}</a></li>
                    <li><span>email:</span>  #{bands.email}</li>
                    <li><span>views:</span>  #{bands.view_count}</li>
                    <li><span>creation:</span>  #{bands.creation_date}</li>
                </ul>
            </li>
            <!-- END bands -->
        </ul>

        <div class="clear"></div>

        <!-- SECTION pagination -->
        <div class="block bottom">
            <!-- INCLUDE lib/view/pagination.tpl -->
        </div>
        <!-- END pagination -->

    </div>


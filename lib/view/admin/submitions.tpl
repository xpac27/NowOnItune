
    <div class="page block" id="admin_submitions">

        <h1 class="cufon_bold">Latest submitions.</h1>
        <h2 class="cufon_normal">#{bands_total_online} online bands (#{bands_total} total).</h2>

        <!-- INCLUDE lib/view/pagination.tpl -->

        <ul class="bands">
            <!-- LOOP bands -->
            <li class="band">
                <ul class="status">
                    <li><label><input type="checkbox" value="1" #{bands.online_checked} onchange="javascript:Admin.band_changeStatus(this, #{bands.id})" />online</label></li>
                    <li><label><input type="checkbox" value="#1" #{bands.public_checked} onchange="javascript:Admin.band_changePublicStatus(this, #{bands.id})" />public</label></li>
                    <li><label><input type="checkbox" value="#1" #{bands.official_checked} onchange="javascript:Admin.band_changeOfficialStatus(this, #{bands.id})" />official</label></li>
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

        <!-- INCLUDE lib/view/pagination.tpl -->

    </div>


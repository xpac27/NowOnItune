
    <div class="page" id="search">

        <div class="block">
            <!-- SECTION search_results -->
            <h1 class="cufon_bold">#{search_total_results} Search results for:</h1>
            <h2 class="cufon_normal">#{search_query}</h2>
            <!-- END search_results -->

            <!-- SECTION no_results -->
            <h1 class="cufon_bold">Oups !</h1>
            <!-- END no_results -->

            <!-- SECTION bad_query -->
            <h1 class="cufon_bold">Error !</h1>
            <!-- END bad_query -->
        </div>

        <!-- SECTION search_results -->
        <ul class="bands">
            <!-- LOOP bands -->
            <!-- INCLUDE lib/view/band/item.tpl -->
            <!-- END bands -->
        </ul>
        <!-- END search_results -->

        <!-- SECTION no_results -->
        <p class="block message">No results were found for your query !</p>
        <!-- END no_results -->

        <!-- SECTION bad_query -->
        <p class="block message">Your query must contain at least 3 character !</p>
        <!-- END bad_query -->

        <div class="clear"></div>

        <!-- SECTION pagination -->
        <div class="block bottom">
            <!-- INCLUDE lib/view/pagination.tpl -->
        </div>
        <!-- END pagination -->

    </div>



var Admin =
{

    working : false,

    band_changeStatus : function(input, id)
    {
        var param =
        {
            'status' : input.checked ? 1 : 0,
            'id'     : id
        };

        new Ajax.Request(ROOT_PATH + 'remote/admin/band/edit',
        {
            parameters: $H(param).toQueryString()
        });
    },

    band_changeOfficialStatus : function(input, id)
    {
        var param =
        {
            'officialStatus' : input.checked ? 1 : 0,
            'id'             : id
        };

        new Ajax.Request(ROOT_PATH + 'remote/admin/band/edit',
        {
            parameters: $H(param).toQueryString()
        });
    },

    band_changePublicStatus : function(input, id)
    {
        var param =
        {
            'publicStatus' : input.checked ? 1 : 0,
            'id'           : id
        };

        new Ajax.Request(ROOT_PATH + 'remote/admin/band/edit',
        {
            parameters: $H(param).toQueryString()
        });
    },

    band_changeFilters : function()
    {
        if (Admin.working)
        {
            return;
        }
        Admin.working = true;

        var filter = '';

        $$('#admin_submitions .filters input').each(function(item)
        {
            if (item.checked)
            {
                filter = filter + ((filter == '') ? '' : '+') + item.readAttribute('name');
            }
        });

        window.location = ROOT_PATH + 'admin/submitions' + ((filter == '') ? '' : '/' + filter);
    }

};


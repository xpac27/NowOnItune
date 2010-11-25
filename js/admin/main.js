var Admin =
{

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
    }

};


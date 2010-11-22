window.onload = function ()
{
};

function startBandAnimation()
{
    if ($('band'))
    {
        setTimeout(function()
        {
            Animation.animateElement($('band_cover'), 'opacity', 0, 1, 1000);
        }, 2000);
        setTimeout(function()
        {
            Animation.animateElement($('band_name'), 'opacity', 0, 1, 1000);
        }, 3000);
        setTimeout(function()
        {
            Animation.animateElement($('band_now'), 'opacity', 0, 1, 1000);
        }, 4500);
        setTimeout(function()
        {
            Animation.animateElement($('band_mask'), 'opacity', 1, 0, 500);
        }, 6500);
        setTimeout(function()
        {
            $('band_mask').remove();
            $$('#band .share, #band .permalink').each(function(item)
            {
                item.setStyle(
                {
                    'visibility' : 'visible'
                });
            });
        }, 7000);
    }
}


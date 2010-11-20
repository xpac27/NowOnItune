var Animation =
{
    animations : [],

    animateElement : function(element, attribute, from, destination, duration)
    {
        if (!this.animations[element.identify()])
        {
            this.animations[element.identify()] =
            {
                animationDuration         : 1000,
                animationDurationout      : 0,
                animationStartTime        : 0,
                animationStartValue       : 0,
                animationDestinationValue : 0,
                animationAttribute        : 0
            };
        }

        clearTimeout(this.animations[element.identify()].animationDurationout);

        from !== null ? from : element.getStyle(attribute);
        from = typeof from == 'string' ? parseInt(from.replace(/px/, ''), 10) : from;

        if (typeof destination == 'string')
        {
            destination = eval(currentValue + destination);
        }

        this.animations[element.identify()].animationStartTime        = new Date().getTime();
        this.animations[element.identify()].animationStartValue       = from;
        this.animations[element.identify()].animationDestinationValue = destination;
        this.animations[element.identify()].animationAttribute        = attribute;
        this.animations[element.identify()].animationDuration         = duration;

        this.setAttribute(element, from);
        this.animateElementCallback(element);

        element.setStyle(
        {
            'visibility' : 'visible'
        });
    },

    animateElementCallback : function(element)
    {
        var ratio = (new Date().getTime() - this.animations[element.identify()].animationStartTime) / this.animations[element.identify()].animationDuration;
        //ratio = (ratio=ratio-1)*ratio*ratio + 1; // easeOutCubic

        var value = this.animations[element.identify()].animationStartValue + ((this.animations[element.identify()].animationDestinationValue - this.animations[element.identify()].animationStartValue) * ratio);

        if (ratio < 1)
        {
            this.setAttribute(element, value);
            this.animations[element.identify()].animationDurationout = setTimeout(this.animateElementCallback.bind(this, element), 35);
        }
        else
        {
            this.setAttribute(element, this.animations[element.identify()].animationDestinationValue);
        }
    },

    setAttribute : function(element, value)
    {
        var style = {};
        switch (this.animations[element.identify()].animationAttribute)
        {
            case 'opacity':
                style[this.animations[element.identify()].animationAttribute] = value;
                break;

            default:
                style[this.animations[element.identify()].animationAttribute] = value + 'px';
                break;
        }
        element.setStyle(style);
    }
};


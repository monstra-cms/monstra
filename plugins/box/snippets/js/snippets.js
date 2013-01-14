var Snippents = Snippents || (function($) {

    var Events  = {}, // Event-based Actions      
        App     = {}, // Global Logic and Initializer
        Public  = {}; // Public Functions

    Events = {
        endpoints: {
            viewEmbedCode: function(){
                var name = $(this).attr("data-value");
                $('#shortcode').html('{snippet get="'+name+'"}');
                $('#phpcode').html('&lt;?php echo Snippet::get("'+name+'"); ?&gt;');
                $('#embedCodes').modal();
            }
        },
        bindEvents: function(){            
            $('[data-event]').each(function(){
                var $this = $(this),
                    method = $this.attr('data-method') || 'click',
                    name = $this.attr('data-event'),
                    bound = $this.attr('data-bound')=='true';

                if(typeof Events.endpoints[name] != 'undefined'){
                    if(!bound){
                        $this.attr('data-bound', 'true');
                        $this.on(method, Events.endpoints[name]);
                    }
                }
            });            
        },
        init: function(){
            Events.bindEvents();
        }
    };
    
    App = {
        logic: {},
        init: function() {            
            Utils.settings.init();
            Events.init();             
        }
    };
    
    Public = {
        init: App.init  
    };

    return Public;

})(window.jQuery);

jQuery(document).ready(Snippents.init);

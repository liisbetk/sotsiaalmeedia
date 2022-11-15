(function ($, Drupal) {
    Drupal.behaviors.EpicCounter = {
      attach: function (context, settings) {
        $('.js-social-media-links', context).once('CountClicks').each(function () {
            
            $('a').click(function() {
                var network = $(this).attr('class');
                
                $.ajax({
                    type: 'POST',
                    url: '/ajax/epic-social-media/counter',
                    data: { network },
                    success: function() {
                        console.log("Ajax call SUCCES");
                    },
                    
                    error: function() {
                        console.log("Ajax call FAILED");
                    }
                })
                
            });
        });
      }
    };
  })(jQuery, Drupal);
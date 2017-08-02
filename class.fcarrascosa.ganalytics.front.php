<?php

/**
 * Created by PhpStorm.
 * User: fcarrascosa
 * Date: 2/12/16
 * Time: 1:58
 */
class FCGoogleAnalytics_Front
{

    public function __construct() {

        add_action ('wp_head', array($this, 'analyticsToHead'));

    }

    public function gaCode() {

        $content = false;

        if (get_option ('fc_google_code')) {

            $content = get_option ('fc_google_code');

        };

        return $content;

    }

    public function analyticsToHead() {

        if ($this->gaCode() != false) {

            ?>

            <!--GOOGLE ANALYTICS-->
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', '<?php echo esc_html($this->gaCode());?>', 'auto');
                ga('send', 'pageview');

            </script>
            <!--/GOOGLE ANALYTICS-->

            <?php

        }

    }

}

$fcGoogleAnalyticsFront = new FCGoogleAnalytics_Front();
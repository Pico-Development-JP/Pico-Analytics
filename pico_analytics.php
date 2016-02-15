<?php

/**
 * Google Analytics貼り付けプラグイン
 *
 * @author TakamiChie
 */
 
class Pico_Analytics {

  private $analytics_code = null;

  public function config_loaded(&$settings)
  {
    if(isset($settings['google_analytics_id'])){
      $this->analytics_code = $settings['google_analytics_id'];
    }
  }

  public function after_render(&$output)
  {
    if($this->analytics_code){
      $id = $this->analytics_code;
      $code = <<< CODE
<script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

   ga('create', '{$id}', 'auto')
   ga('send', 'pageview')

</script>
CODE;
      // 書き込み処理
      $output = preg_replace("/<\/head>/", "$code</head>", $output, 1);
    }
  }

}

?>

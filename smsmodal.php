<?php
  // include_once("smsSender.php");
    $theme = shopify_call($token, $shop_url, "/admin/api/2020-10/themes.json", array(), 'GET');
    $theme = json_decode($theme['response'], JSON_PRETTY_PRINT);
    // print_r($theme['response']);
    foreach ($theme as $cur_theme) {
      foreach ($cur_theme as $theme) {
        if($theme['role'] == 'main'){
          $theme_id = $theme['id'];
          $array = array('asset' => array("key" => 'layout/theme.liquid'));
          $assets = shopify_call($token, $shop_url, "/admin/api/2020-10/themes/" . $theme_id . "/assets.json", $array, 'GET');
          $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);

          //===========================================================
          //            SNIPPET CODE FOR CSS
          //===========================================================

          $snippet = "{% include 'alertcss' %}";

          $head_tag = '</head>';

          $new_head_tag = $snippet . $head_tag;
          $theme_liquid = $assets['asset']['value'];

          $new_theme_liquid = str_replace($head_tag, $new_head_tag, $theme_liquid);

          if(strpos($assets['asset']['value'], $snippet) === false){
            $array = array(
              'asset' => array(
                'key' => 'layout/theme.liquid',
                'value' => $new_theme_liquid
              )
            );
            $assets = shopify_call($token, $shop_url, "/admin/api/2020-10/themes/" . $theme_id . "/assets.json", $array, 'PUT');
            $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
          }

          //===========================================================
          //            SNIPPET CODE FOR JS
          //===========================================================

          $snippet = '{% include "alertjs" %}';

          $body_tag = '</body>';

          $new_body_tag = $snippet . $body_tag;
          $theme_liquid = $assets['asset']['value'];

          $new_theme_liquid = str_replace($body_tag, $new_body_tag, $theme_liquid);

          if(strpos($assets['asset']['value'], $snippet) === false){
            $array = array(
              'asset' => array(
                'key' => 'layout/theme.liquid',
                'value' => $new_theme_liquid
              )
            );
            $assets = shopify_call($token, $shop_url, "/admin/api/2020-10/themes/" . $theme_id . "/assets.json", $array, 'PUT');
            $assets = json_decode($assets['response'], JSON_PRETTY_PRINT);
          }

          $snippet_css_liquid = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">';

          $snippet_js_liquid = '
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#runnSMsms">
            MSM
          </button>
          <div class="modal fade" id="runnSMsms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>

          <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
          <script>
          jQuery(document).ready(function() {
          	$("body").prepend("<div class=\'header\' id=\'myHeader\'><h2>Thank you for reading WeeklyHows Tutorial!</h2><button id="gift_hint">Send Hint</button></div>");
          	$("head").prepend("<style>.header { padding: 10px 16px; background: #555; color: #f1f1f1; } .content { padding: 16px; } .sticky { position: fixed; top: 0; width: 100%} .sticky + .content { padding-top: 102px; }</style>");

          	var header = document.getElementById("myHeader");
          	var sticky = header.offsetTop;

          	window.onscroll = function() {
          		if (window.pageYOffset > sticky) {
          			header.classList.add("sticky");
          		} else {
          			header.classList.remove("sticky");
          		}
          	};

            $("#gift_hint").click(function(){
              alert("SMS sent!");
            });
          });

          </script>';

          $arrayCss = array(
            "asset" => array(
              "key" => 'snippets/alertcss.liquid',
              "value" => $snippet_css_liquid
            )
          );
          $arrayJs = array(
            "asset" => array(
              "key" => 'snippets/alertjs.liquid',
              "value" => $snippet_js_liquid
            )
          );

          $snippetCSS = shopify_call($token, $shop_url, "/admin/api/2020-10/themes/" . $theme_id . "/assets.json", $arrayCss, 'PUT');
          $snippetCSS = json_decode($snippetCSS['response'], JSON_PRETTY_PRINT);

          $snippetJS = shopify_call($token, $shop_url, "/admin/api/2020-10/themes/" . $theme_id . "/assets.json", $arrayJs, 'PUT');
          $snippetJS = json_decode($snippetJS['response'], JSON_PRETTY_PRINT);

        }
      }
    }
 ?>

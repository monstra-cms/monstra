<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>
    <style type="text/css">
      <?php include PLUGINS_BOX . '/emails/css/inc.css'; ?>
    </style>
    <style type="text/css">      
      .email-header {
        padding: 10px 20px 10px 0px;
      }
      .email-content {
        border: 1px solid #F5F5F5;
        background: #fdfdfd;
        padding: 20px 20px 20px 20px;
      }
    </style>
  </head>
  <body>   
    <table class="body">
      <tr>
        <td class="center" align="center" valign="top">
          <center>
            <table class="container">
              <tr>
                <td>
                  <table class="row">
                    <tr>
                      <td class="wrapper">
                        <table class="twelve columns">
                          <tr>
                            <td class="email-header" style="padding:10px 20px 10px 0px;">
                              <h1><?php echo $site_name; ?></h1>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table class="row">
                    <tr>
                      <td class="wrapper">
                        <table class="twelve columns">
                          <tr>
                            <td class="email-content" style="border:1px solid #F5F5F5; background:#fdfdfd; padding:20px 20px 20px 20px;">
                              <?php include STORAGE . DS . 'emails' . DS . $email_template . '.email.php'; ?>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
    </table>
  </body>
</html>
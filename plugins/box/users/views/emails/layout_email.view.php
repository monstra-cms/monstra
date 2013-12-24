<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo Option::get('sitename'); ?></title>

    <!-- Facebook sharing information tags -->
    <meta property="og:title" content="<?php echo Option::get('sitename'); ?>" />

    <style type="text/css">
        /* Based on The MailChimp Reset INLINE: Yes. */         
        /* Force Outlook to provide a "view in browser" menu link. */
        #outlook a {
            padding:0; 
        } 

        body { 
            width: 100% !important;
            -webkit-text-size-adjust: 100%; 
            -ms-text-size-adjust: 100%; 
            margin: 0; 
            padding: 0; 
            font-family: Arial,Helvetica,sans-serif;
            font-size: 13px; 
            line-height: 1.4;
        }  
                 
        /* Force Hotmail to display emails at full width */  
        .ExternalClass {
            width: 100%;
        } 

        /* Prevent Webkit and Windows Mobile platforms from changing default font sizes. */
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }
        
        /* Forces Hotmail to display normal line spacing. More info: http://www.emailonacid.com/forum/viewthread/43/ */ 
        #backgroundTable {
            margin: 0; 
            padding: 0; 
            width: 100% !important; 
            line-height: 100% !important;
        }
        /* End reset */

        /* Images
        Bring inline: Yes. */
        img { 
            outline: none; 
            text-decoration: none; 
            -ms-interpolation-mode: bicubic;
        } 
        a img { 
            border:none;
        } 

        /* Yahoo paragraph fix
        Bring inline: Yes. */
        p { 
            margin: 1em 0;
        }

        /* Hotmail header color reset
        Bring inline: Yes. */
        h1, h2, h3, h4, h5, h6 {color: #000 !important;}

        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: #000 !important;}

        /* Headers links color */
        h1 a:active,
        h2 a:active,
        h3 a:active, 
        h4 a:active, 
        h5 a:active, 
        h6 a:active {
            color: #000 !important; 
        }
        h1 a:visited,
        h2 a:visited,  
        h3 a:visited, 
        h4 a:visited, 
        h5 a:visited, 
        h6 a:visited {
            color: #000 !important; 
        }

        /* Outlook 07, 10 Padding issue fix
        Bring inline: No.*/
        table td { 
            border-collapse: collapse;
        }

        /* Remove spacing around Outlook 07, 10 tables
        Bring inline: Yes */
        table { 
            border-collapse:collapse; 
            mso-table-lspace:0pt; 
            mso-table-rspace:0pt; 
        }

        /* Styling your links
        Bring inline: Yes. */
        a {
            color: #000;
        }

        /* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers.
           More info: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/ */
        a[href^="tel"],
        a[href^="sms"] {
            text-decoration: none;
            color: #000;
            pointer-events: none;
            cursor: default;
        }

        .mobile_link a[href^="tel"],
        .mobile_link a[href^="sms"] {
            text-decoration: default;
            color: #000 !important;
            pointer-events: auto;
            cursor: default;
        }

        /* Phones */            
        @media only screen and (max-device-width: 480px) {

            /* Hide elements at smaller screen sizes (!important needed to override inline CSS). */
            .hide {
                display: none !important;
            }

            /* Adjust table widths at smaller screen sizes. */
            .table {
                width: 300px !important;
            }

            /* Adjust logo widths at smaller screen sizes. */
            .logo { 
                height: 75px !important; 
                width: 300px !important;
            }
        }

        /* Tablets */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {

        }

    </style>

    <!-- Windows Mobile -->
    <!--[if IEMobile 7]>
    <style type="text/css">
    
    </style>
    <![endif]-->

    <!-- Outlook 2007 and 2010 -->
    <!--[if gte mso 9]>
        <style>
        
        </style>
    <![endif]-->
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<!-- Wrapper -->
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
    <tr>
        <td align="center" valign="top">
            <!-- Template-->
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="table" style="border:1px solid #ccc;" bgcolor="#fdfdfd">
                <!-- Content -->
                <tr>
                    <td valign="top" style="padding:20px;">
                        <p style="margin-top:0; margin-bottom:0;">
                            <?php include $view.'.view.php'; ?>
                        </p>
                    </td>
                </tr>
                <!-- /Content -->
                <!-- Footer -->
                <tr>
                    <td>
                        <table width="100%" cellpadding="10" cellspacing="0" border="0">
                            <tr>
                                <td valign="top" style="font-size:11px; border-top:1px dashed #ccc; text-align:right;">
                                    <p style="margin-top:0; margin-bottom:0;">
                                        
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- /Footer -->
            </table>
            <!-- /Template -->
        </td>
    </tr>
</table>  
<!-- /Wrapper -->
</body>
</html>